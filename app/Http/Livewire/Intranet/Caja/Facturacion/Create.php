<?php

namespace App\Http\Livewire\Intranet\Caja\Facturacion;

use App\Rules\Caja\TipoPago as CajaTipoPago;
use App\Rules\Caja\TipoDocumentoFactura;
use Barryvdh\Debugbar\Facades\Debugbar;
use Illuminate\Support\Facades\Auth;
use App\Services\FacturacionService;
use App\Models\CajaTipoComprobante;
use App\Models\CajaAperturaCierre;
use App\Services\PersonaService;
use App\Models\TipoNotaCredito;
use App\Models\TipoComprobante;
use App\Models\TipoDocumento;
use App\Models\UnidadMedida;
use App\Models\Comprobante;
use Illuminate\Support\Str;
use App\Models\TipoPago;
use Livewire\Component;
use App\Models\Moneda;
use App\Models\Venta;
use App\Models\Caja;

class Create extends Component
{
    public $documentable_id = null;
    public $documentable_type = null;
    public $caja_apertura_cierre_id;
    public $caja_id;
    public $comprobante_id = null;
    public $form = [];
    public $comprobante = null;

    protected function rules(){
        $rules = [
			'form.documentable_id' => 'nullable',
			'form.documentable_type' => 'nullable',
			'form.caja_apertura_cierre_id' => 'required|exists:caja_apertura_cierres,id',
			'form.caja_id' => 'required|exists:cajas,id',
			'form.moneda_id' => 'required|exists:monedas,id',
			'form.tipo_documento_id' => [
                'required',
                'exists:tipo_documentos,id',
                new TipoDocumentoFactura($this->form['nro_documento'] ?? null, $this->form['tipo_comprobante_id'] ?? null),
            ],
			'form.tipo_comprobante_id' => 'required|exists:tipo_comprobantes,id',
			'form.tipo_pago_id' => ['required', 'exists:tipo_pagos,id', new CajaTipoPago($this->form)],
			'form.comprobante_modifica_id' => 'nullable|exists:comprobantes,id',
			'form.nro_documento' => 'required',
			'form.denominacion' => 'required',
			'form.direccion' => 'nullable|string',
			'form.fecha_emision' => 'required',
			'form.fecha_vencimiento' => 'required',
			'form.tipo_nota_credito_id' => 'nullable|exists:tipo_nota_creditos,id',
            'form.observaciones' => 'nullable|string',
            'form.fecha_credito' => 'nullable|date',
            'form.nro_cuotas' => 'nullable|numeric',
        ];

        return $rules;
    }

    protected $queryString = [
        'documentable_id',
        'documentable_type',
        'caja_apertura_cierre_id',
        'comprobante_id',
        'caja_id'
    ];

    public function mount()
    {
        $this->documento = $this->documentable_type == null ? null : $this->documentable_type::find($this->documentable_id);
        $this->caja_apertura_cierre = CajaAperturaCierre::find($this->caja_apertura_cierre_id);
        $this->caja = Caja::find($this->caja_id);
        $this->comprobante_modifica = Comprobante::find($this->comprobante_id);
        $this->tipo_documentos = TipoDocumento::get();
        $this->monedas = Moneda::get();
        $this->tipo_comprobantes = TipoComprobante::whereIn('id', [1,2])->get();
        $this->tipo_pagos = TipoPago::get();
        $this->tipo_nota_creditos = TipoNotaCredito::get();
        $this->form['caja_apertura_cierre_id'] = $this->caja_apertura_cierre->id ?? null;
        $this->form['caja_id'] = $this->caja->id;
        $this->form['fecha_emision'] = date('Y-m-d');
        $this->form['fecha_vencimiento'] = date('Y-m-d');
        $this->form['tipo_documento_id'] = $this->documento->clientable->tipo_documento_id ?? $this->comprobante_modifica->tipo_documento_id ?? null;
        $this->form['nro_documento'] = $this->documento->clientable->nro_doc ?? $this->comprobante_modifica->nro_documento ?? null;
        $this->form['denominacion'] = $this->documento->clientable->nombre_completo_invertido ?? $this->comprobante_modifica->denominacion ?? null;
        $this->form['moneda_id'] = $this->monedas->firstWhere('descripcion', 'Soles')->id;
        $this->form['tipo_pago_id'] = $this->tipo_pagos->firstWhere('descripcion', 'Efectivo')->id;
        $this->form['observaciones'] = $this->obtenerObservacion();

        if (isset($this->comprobante_modifica)) {
            $this->tipo_comprobantes = TipoComprobante::whereIn('id', [3])->get();
            $this->form['tipo_comprobante_id'] = TipoComprobante::whereDescripcion('Nota de Crédito')->first()->id;
            $this->form['comprobante_modifica_id'] = $this->comprobante_modifica->id;
            $this->form['serie_documento_modifica'] = $this->comprobante_modifica->serie;
            $this->form['correlativo_documento_modifica'] = $this->comprobante_modifica->correlativo;
            $this->setCorrelativoComprobante();
        }
    }

    public function render()
    {
        return view('livewire.intranet.caja.facturacion.create');
    }

    public function save()
    {
        $this->comprobante ? $this->update() : $this->store();
        $this->return();
    }

    public function store()
    {
        $form = $this->validate();
        // dd($form);
        $this->comprobante = ($this->documento == null)
                             ? Comprobante::create($form['form'])
                             : $this->documento->comprobante()->create($form['form']);

        if (!isset($this->comprobante->comprobante_modifica)) {
            $this->documento->detalle->each(function ($item, $key) {
                $this->comprobante->detalles()->create([
                    'unidad_medida_id' => UnidadMedida::whereDescripcion('Servicio')->first()->id,
                    'descripcion' => $item->descripcion,
                    'cantidad' => $item->cantidad,
                    'precio_unitario' => $item->monto,
                ]);
            });
        }

        $json = FacturacionService::enviarJson($this->comprobante, "generar_comprobante");
    }

    public function update()
    {
        //
    }

    public function return()
    {
        $this->form = [];
        $this->emit('closeModals');

        if ($this->comprobante->ultima_respuesta->errors == null) {
            if ($this->comprobante->comprobante_modifica_id != null) {
                redirect()->route('intranet.caja.comprobante.index')->with('success', 'Facturación generada correctamente');
            } else {
                redirect()->route('intranet.caja.caja.show', $this->comprobante->caja_apertura_cierre->caja_id)->with('success', 'Facturación generada correctamente');
            }
        }
        else
            redirect()->route('intranet.caja.caja.show', $this->comprobante->caja_apertura_cierre->caja_id)->with('danger', 'Se facturó con errores, verifique el documento');


    }

    public function setCorrelativoComprobante()
    {
        $data = FacturacionService::obtenerCorrelativo($this->form['tipo_comprobante_id'], $this->caja->id, $this->comprobante_modifica);

        if (isset($data['correlativo'])) {
            $this->form['serie'] = $data['serie'];
            $this->form['correlativo'] = $data['correlativo'];
        } else {
            $this->emit('notify', 'error', 'No existe un tipo de comprobante registrado para la facturación');
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
            $this->form['direccion'] = $persona->direccion ?? null;
        } else {
            $this->form['denominacion'] = null;
            $this->form['nro_documento'] = null;
            $this->emit('notify', 'error', 'No se encontró resultados');
        }
    }

    public function getTipoPagoDescProperty()
    {
        return TipoPago::find($this->form['tipo_pago_id'])->descripcion;
    }

    public function obtenerObservacion()
    {
        if ($this->documento) {
            if ($this->documento->detalle[0]->documentable_type == 'App\Models\Pasaje') {
                if (!$this->documento->detalle[0]->documentable->is_abierto) {
                    if($this->documento->detalle[0]->documentable->vuelos[0]->tipo_vuelo->descripcion == 'Subvencionado') {
                        return 'Lugar Procedencia: ' . optional(optional($this->documento->clientable ?? null)->ubigeo ?? null)->descripcion ?? null;
                    }
                }
            }
        }

        return '';
    }
}
