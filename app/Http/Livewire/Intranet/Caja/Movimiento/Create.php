<?php

namespace App\Http\Livewire\Intranet\Caja\Movimiento;

use App\Models\Caja;
use App\Models\CajaAperturaCierre;
use App\Models\CajaMovimiento;
use App\Models\OficinaCuentaBancaria;
use App\Models\Tarjeta;
use App\Models\TipoMovimiento;
use App\Models\TipoPago;
use App\Models\Venta;
use App\Rules\Caja\MontoMovimiento;
use App\Rules\Caja\TipoPago as CajaTipoPago;
use Barryvdh\Debugbar\Facades\Debugbar;
use Livewire\Component;

class Create extends Component
{
    public $caja_apertura_cierre_id;
    public $caja_movimiento = null;
    public $form = [];
    public $venta_id;
    public $caja_id;

    protected function rules()
    {
        $rules = [
            'form.fecha_pago' => 'required|date',
            'form.tipo_pago_id' => ['required', 'exists:tipo_pagos,id', new CajaTipoPago($this->form)],
            'form.monto' => ['required','numeric','min:0', new MontoMovimiento($this->venta_id)],
            'form.nro_operacion' => 'nullable|numeric',
            'form.cuenta_bancaria_id' => 'nullable|exists:oficina_cuenta_bancarias,id',
            'form.tarjeta_id' => 'nullable|exists:tarjetas,id',
            'form.porcentaje_cargo' => 'nullable|numeric',
            'form.fecha_credito' => 'nullable|date',
            'form.nro_cuotas' => 'nullable|numeric',
        ];

        return $rules;
    }

    public function mount()
    {
        $this->caja_apertura_cierre = CajaAperturaCierre::find($this->caja_apertura_cierre_id);
        $this->venta = Venta::find($this->venta_id);
        $this->caja = Caja::find($this->caja_id);
        $this->tipo_pagos = TipoPago::get();
        $this->cuentas_bancarias = OficinaCuentaBancaria::get();
        $this->tarjetas = Tarjeta::get();
        $this->form['fecha_pago'] = date('Y-m-d');
        $this->form['tipo_pago_id'] = 1;
    }

    public function render()
    {
        return view('livewire.intranet.caja.movimiento.create');
    }

    public function save()
    {
        $this->caja_movimiento ? $this->update() : $this->store();
        $this->return();
    }

    public function store()
    {
        $form = $this->validate();
        $this->caja_movimiento = CajaMovimiento::create(array_merge($form['form'], [
            'caja_id' => $this->caja_apertura_cierre->caja_id,
            'apertura_cierre_id' => $this->caja_apertura_cierre->id,
            'tipo_movimiento_id' => TipoMovimiento::whereDescripcion('Ingreso')->first()->id,
            'documentable_type' => get_class($this->venta),
            'documentable_id' => $this->venta->id,
            'fecha' => date('Y-m-d')
        ]));
    }
    public function return()
    {
        $this->form = [];
        $this->form['fecha_pago'] = date('Y-m-d');
        $this->caja_movimiento = null;
        $this->emit('closeModals');
        $this->emit('movimientoCreated');
        $this->emit('notify', 'success', 'Se registró correctamente 😃.');
    }

    public function getTipoPagoDescProperty()
    {
        $descripcion = optional(TipoPago::find($this->form['tipo_pago_id'] ?? null) ?? null)->descripcion;
        return $descripcion;
    }

    public function getTotalProperty()
    {
        $porcentaje_cargo = 0; $monto = 0;

        if (array_key_exists('porcentaje_cargo', $this->form))
            $porcentaje_cargo = round((double) $this->form['porcentaje_cargo'] / 100, 2);

        if (array_key_exists('monto', $this->form))
            $monto = (double) $this->form['monto'];

        return round($monto + ($monto * $porcentaje_cargo), 1);
    }

    public function selectTipoPago()
    {
        if ($this->form['tipo_pago_id'] != 2) {
            $this->form['tarjeta_id'] = null;
            $this->form['porcentaje_cargo'] = null;
        }

        if ($this->form['tipo_pago_id'] != 3) {
            $this->form['cuenta_bancaria_id'] = null;
            $this->form['nro_operacion'] = null;
        }

        if ($this->form['tipo_pago_id'] != 4) {
            $this->form['fecha_credito'] = null;
            $this->form['nro_cuotas'] = null;
        }
    }
}
