<?php

namespace App\Http\Livewire\Intranet\Caja\CuentaCobrar;

use App\Rules\Caja\TipoPago as CajaTipoPago;
use App\Rules\Caja\TipoDocumentoFactura;
use Barryvdh\Debugbar\Facades\Debugbar;
use Illuminate\Support\Facades\Auth;
use App\Services\FacturacionService;
use App\Services\PersonaService;
use App\Models\TipoComprobante;
use App\Models\TipoDocumento;
use App\Models\CuentaCobrar;
use Illuminate\Support\Str;
use App\Models\TipoPago;
use Livewire\Component;
use App\Models\Moneda;
use App\Models\Caja;
use App\Models\Comprobante;
use App\Models\UnidadMedida;
use Illuminate\Support\Facades\DB;

class Facturar extends Component
{
    public CuentaCobrar $cuenta_cobrar;
    public $comprobante = null;
    public $form = [];
    public $tipo_comprobantes = null;
    public $tipo_documentos = null;
    public $monedas = null;
    public $tipo_pagos = null;
    public $cajas = null;
    public $cuotas = [];
    public $formCuota = [];

    protected function rules(){
        $rules = [
			'form.documentable_id' => 'nullable',
			'form.documentable_type' => 'nullable',
			'form.caja_id' => 'required|exists:cajas,id',
			'form.moneda_id' => 'required|exists:monedas,id',
			'form.tipo_documento_id' => [
                'required',
                'exists:tipo_documentos,id',
                new TipoDocumentoFactura($this->form['nro_documento'] ?? null, $this->form['tipo_comprobante_id'] ?? null)
            ],
			'form.tipo_comprobante_id' => 'required|exists:tipo_comprobantes,id',
			'form.tipo_pago_id' => [
                'required',
                'exists:tipo_pagos,id', new CajaTipoPago($this->form, $this->cuenta_cobrar)
            ],
			'form.comprobante_modifica_id' => 'nullable|exists:comprobantes,id',
			'form.nro_documento' => 'required',
			'form.denominacion' => 'required',
			'form.direccion' => 'nullable|string',
			'form.fecha_emision' => 'required',
			'form.fecha_vencimiento' => 'required',
			'form.tipo_nota_credito_id' => 'nullable|exists:tipo_nota_creditos,id',
            'form.observaciones' => 'nullable|string',
            'form.cuotas' => 'nullable|array'
        ];

        return $rules;
    }

    public function mount()
    {
        $this->tipo_comprobantes = TipoComprobante::whereIn('id', [1])->get();
        $this->tipo_documentos = TipoDocumento::get();
        $this->monedas = Moneda::get();
        $this->form['moneda_id'] = Moneda::whereDescripcion('Soles')->first()->id;
        $this->tipo_pagos = TipoPago::get();
        $this->cajas = Caja::whereIn('id', Auth::user()->personal->cajas->pluck('id'))->get();
        $this->form['tipo_pago_id'] = $this->tipo_pagos->firstWhere('descripcion', 'Efectivo')->id;
        $this->form['nro_documento'] = $this->cuenta_cobrar->clientable->ruc;
        $this->form['denominacion'] = $this->cuenta_cobrar->clientable->razon_social;
        $this->form['tipo_documento_id'] = $this->tipo_documentos->firstWhere('descripcion', 'RUC')->id;
        $this->form['fecha_emision'] = date('Y-m-d');
        $this->form['fecha_vencimiento'] = date('Y-m-d');
    }

    public function render()
    {
        return view('livewire.intranet.caja.cuenta-cobrar.facturar');
    }

    public function save()
    {
        $this->comprobante ? $this->update() : $this->store();
        $this->return();
    }

    public function store()
    {
        $this->form['cuotas'] = $this->cuotas;
        $form = $this->validate();

        DB::transaction(function () use ($form) {
            $this->comprobante = $this->cuenta_cobrar->comprobante()->create($form['form']);

            $this->cuenta_cobrar->detalles->each(function ($item, $key) {
                $this->comprobante->detalles()->create([
                    'unidad_medida_id' => UnidadMedida::whereDescripcion('Servicio')->first()->id,
                    'descripcion' => $item->concepto,
                    'cantidad' => $item->cantidad,
                    'precio_unitario' => round($item->importe / $item->cantidad, 2),
                ]);
            });

            if ($this->comprobante->tipo_pago->descripcion == 'Crédito') {
                $c = 1;
                foreach($form['form']['cuotas'] as $cuota) {
                    $this->comprobante->cuotas()->create([
                        'nro_cuota' => $c,
                        'fecha_pago' => $cuota['fecha'],
                        'importe' => $cuota['importe'],
                    ]);

                    $c++;
                }
            }
        });

        $json = FacturacionService::enviarJson($this->comprobante, "generar_comprobante");
    }

    public function update()
    {
        //
    }

    public function setCorrelativoComprobante()
    {
        $data = FacturacionService::obtenerCorrelativo($this->form['tipo_comprobante_id'], $this->form['caja_id']);

        if (isset($data['correlativo'])) {
            $this->form['serie'] = $data['serie'];
            $this->form['correlativo'] = $data['correlativo'];
        } else {
            $this->emit('notify', 'warning', 'No existe un tipo de comprobante registrado para la facturación');
            Debugbar::info('No existe un tipo de comprobante registrado para la facturación');
        }
    }

    public function buscarCliente()
    {
        $search = $this->form['nro_documento'];
        $persona = null;

        if (Str::length($search) == 8)
            $persona = PersonaService::searchPersona($search);

        if (Str::length($search) == 11)
            $persona = PersonaService::searchEmpresa($search);

        if($persona){
            $this->form['denominacion'] = $persona->razon_social ?? $persona->nombre_completo_invertido;
            $this->form['nro_documento'] = $persona->ruc ?? $persona->nro_doc;
            $this->form['direccion'] = $persona->direccion ?? '';
        } else {
            $this->form['denominacion'] = null;
            $this->form['nro_documento'] = null;
            $this->form['direccion'] = null;
            $this->emit('notify', 'error', 'No se encontró resultados');
        }
    }

    public function getTipoPagoDescProperty()
    {
        $this->form['cuotas'] = [];
        return TipoPago::find($this->form['tipo_pago_id'] ?? null)->descripcion;
    }

    public function return()
    {
        $this->form = [];
        $this->emit('closeModals');

        $array = ($this->comprobante->ultima_respuesta->errors == null)
        ? [ 'type' => 'danger', 'msg' => 'Se facturó con errores, verifique el documento' ]
        : [ 'type' => 'success', 'msg' => 'Facturación generada correctamente' ];

        redirect()->route('intranet.caja.cuenta-cobrar.show', $this->cuenta_cobrar->id)->with($array['type'], $array['msg']);
    }

    public function addCuota()
    {
        if (array_key_exists('fecha_pago_cuota', $this->formCuota) & array_key_exists('importe', $this->formCuota)) {
            $this->cuotas[] = [
                'fecha' => $this->formCuota['fecha_pago_cuota'],
                'importe' => $this->formCuota['importe'],
            ];

            $this->formCuota = [];
        }
    }

    public function removeCuota($index)
    {
        unset($this->cuotas[$index]);
    }
}
