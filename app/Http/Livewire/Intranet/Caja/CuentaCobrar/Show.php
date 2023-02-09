<?php

namespace App\Http\Livewire\Intranet\Caja\CuentaCobrar;

use App\Models\CuentaCobrarAmortizacion;
use Barryvdh\Debugbar\Facades\Debugbar;
use App\Rules\Caja\MontoAmortizacion;
use App\Models\OficinaCuentaBancaria;
use App\Models\CuentaCobrarDetalle;
use App\Models\CuentaCobrar;
use App\Models\VueloCredito;
use App\Models\VueloMassive;
use App\Models\Cliente;
use Livewire\Component;
use App\Models\Venta;

class Show extends Component
{
    public CuentaCobrar $cuenta_cobrar;
    public $tab = 'detalles';

    public $form = [
        'fecha_pago',
        'monto',
        'nro_cuenta',
        'descripcion_cuenta',
        'glosa',
    ];

    public function rules(){
        return [
            'form.fecha_pago' => 'required|date',
            'form.monto' => ['required', 'numeric', 'min:0.01', new MontoAmortizacion($this->cuenta_cobrar)],
            'form.nro_cuenta' => 'required|string',
            'form.descripcion_cuenta' => 'required|string',
            'form.glosa' => 'nullable|string',
        ];
    }

    public function mount()
    {
        $this->cuentas_bancarias = OficinaCuentaBancaria::get();
        $this->form['fecha_pago'] = date('Y-m-d');
        $this->form['monto'] = $this->cuenta_cobrar->monto_pago_pendiente;
    }

    public function render()
    {
        return view('livewire.intranet.caja.cuenta-cobrar.show', [
            'subvencionados' => VueloMassive::whereTipoVueloId(3)
                                ->whereClienteId($this->cuenta_cobrar->clientable_id)
                                ->doesntHave('cuenta_cobrar_detalle')
                                ->paginate(10),
            'charter' => VueloCredito::whereHasMorph('clientable',
                            [Cliente::class],
                            function ($query) {
                                $query->whereId($this->cuenta_cobrar->clientable_id);
                            })
                            ->doesntHave('cuenta_cobrar_detalle')
                            ->paginate(10),
            'guias_venta' => Venta::whereHas('detalle', function ($query) {
                                $query->whereDocumentableType('App\\Models\\GuiaDespacho');
                            })
                            ->whereClientableId($this->cuenta_cobrar->clientable_id)
                            ->whereClientableType($this->cuenta_cobrar->clientable_type)
                            ->whereHas('caja_movimiento', function ($query) {
                                $query->whereTipoPagoId(4);
                            })
                            ->has('comprobante')
                            ->doesntHave('cuenta_cobrar_detalle')
                            ->paginate(10)
        ]);
    }

    public function setTab($tab)
    {
        $this->tab = $tab;
    }

    public function saveNewAmortizacion()
    {
        $this->validate();
        $this->cuenta_cobrar->amortizaciones()->create($this->form);

        $this->form = [
            'fecha_pago'    => null,
            'monto'         => null,
            'nro_cuenta'    => null,
            'descripcion_cuenta' => null,
            'glosa'         => null,
        ];

        $this->cuenta_cobrar->refresh();
        $this->emit('closeModals');
        $this->emit('notify', 'success', 'Amortización agregada correctamente');
    }

    public function deleteAmortizacion($id)
    {
        CuentaCobrarAmortizacion::find($id)->delete();
        $this->cuenta_cobrar->refresh();
        $this->emit('notify', 'success', 'Amortización eliminada correctamente');
    }

    public function seleccionarCuenta(OficinaCuentaBancaria $cuenta_bancaria)
    {
        $this->form['nro_cuenta'] = $cuenta_bancaria->nro_cuenta;
        $this->form['descripcion_cuenta'] = $cuenta_bancaria->descripcion_completa;
    }

    public function createDetalle($class, $modal_id)
    {
        $documentable = "App\\Models\\{$class}"::find($modal_id);

        $documentable->cuenta_cobrar_detalle()->create([
            'cuenta_cobrar_id' => $this->cuenta_cobrar->id,
            'cantidad' => $documentable->cantidad,
            'precio_unitario' => $documentable->precio_unitario,
            'concepto' => $documentable->concepto
        ]);

        $this->cuenta_cobrar->refresh();
        $this->emit('closeModals');
        $this->emit('notify', 'success', 'Detalle asignado correctamente');
    }

    public function deleteDetalle($id)
    {
        CuentaCobrarDetalle::find($id)->delete();
        $this->cuenta_cobrar->refresh();
        $this->emit('notify', 'success', 'Detalle eliminado correctamente');
    }
}
