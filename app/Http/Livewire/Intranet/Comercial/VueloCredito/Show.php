<?php

namespace App\Http\Livewire\Intranet\Comercial\VueloCredito;

use App\Models\CuentaBancariaReferencial;
use App\Models\VueloCredito;
use App\Models\VueloCreditoAmortizacion;
use Livewire\Component;

class Show extends Component {
    public VueloCredito $vuelo_credito;
    public $cuentas_referenciales;
    public $form = [
        'fecha_pago',
        'monto',
        'nro_cuenta',
        'descripcion_cuenta',
        'glosa',
    ];
    public function mount(){
        $this->cuentas_referenciales = CuentaBancariaReferencial::get();

        $this->form['fecha_pago'] = date('Y-m-d');
        $this->form['monto'] = $this->vuelo_credito->monto_pago_pendiente;
    }
    public function rules(){
        return [
            'form.fecha_pago' => 'required|date',
            'form.monto' => 'required|numeric',
            'form.nro_cuenta' => 'required|numeric',
            'form.descripcion_cuenta' => 'required|string',
            'form.glosa' => 'nullable|string',
        ];
    }
    public function render() {
        return view('livewire.intranet.comercial.vuelo-credito.show');
    }

    public function delete(VueloCreditoAmortizacion $vueloCreditoAmortizacion){
        $vueloCreditoAmortizacion->delete();
        $this->vuelo_credito->refresh();
        $this->emit('notify', 'success', 'Amortización eliminada correctamente');
    }

    public function saveNewAmortizacion(){
        $this->validate();
        if($this->vuelo_credito->monto_pago_pendiente < $this->form['monto']){
            $this->emit('notify', 'error', 'El monto a pagar es mayor al monto pendiente');
            return;
        }
        $this->vuelo_credito->amortizaciones()->create($this->form);

        $amortizaciones_total = VueloCreditoAmortizacion::where('vuelo_credito_id', $this->vuelo_credito->id)->sum('monto');

        if($amortizaciones_total >= $this->vuelo_credito->monto){
            $this->vuelo_credito->update(['is_pagado' => true]);
        }
        $this->form = [
            'fecha_pago'    => null,
            'monto'         => null,
            'nro_cuenta'    => null,
            'descripcion_cuenta' => null,
            'glosa'         => null,
        ];

        $this->vuelo_credito->refresh();
        $this->emit('closeModals');
        $this->emit('notify', 'success', 'Amortización agregada correctamente');
    }
    public function seleccionarCuenta(CuentaBancariaReferencial $cuentaBancariaReferencial){
        $this->form['nro_cuenta'] = $cuentaBancariaReferencial->nro_cuenta;
        $this->form['descripcion_cuenta'] = $cuentaBancariaReferencial->descripcion_cuenta;
    }
}
