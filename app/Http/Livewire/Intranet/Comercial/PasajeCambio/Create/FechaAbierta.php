<?php

namespace App\Http\Livewire\Intranet\Comercial\PasajeCambio\Create;

use App\Models\Pasaje;
use App\Models\PasajeLiberacionHistorial;
use App\Models\Venta;
use Livewire\Component;

class FechaAbierta extends Component {
    public Pasaje $pasaje;

    public $importe_penalidad = null;
    public $nota = '';
    public $is_sin_pagar = false;
    public $monto = 0;

    public $approved_by_id = null;
    public $approved_observation = null;

    public function rules(){
        return [
            'pasaje_id'    => 'required',
            'tipo_pasaje_cambio_id'    => 'required',
            // 'importe_penalidad' => 'nullable|numeric|min:0',
            'nota'              =>  $this->is_sin_pagar ? 'required' : 'nullable',
            'is_sin_pagar'      => 'nullable',
            'approved_by_id'    => 'nullable',
            'approved_observation' => 'nullable'
        ];
    }

    public $listeners = [
        'passwordConfirmed' => 'save'
    ];

    public function mount(){
        $this->monto = $this->pasaje->monto_cambio_abierto;
    }

    public function render() {
        return view('livewire.intranet.comercial.pasaje-cambio.create.fecha-abierta');
    }

    public function save($_ = null, $observacion = null, $userId = null) {
        $this->validate();
        $approved_by_id = $userId;
        $approved_observation = $observacion;

        $codigo_liberacion = uniqid();
        $monto_cambio_abierto = $this->is_sin_pagar ? 0 : $this->monto;
        $this->pasaje->update([
            'is_abierto' => true,
            'fecha_was_abierto' => now(),
        ]);
        foreach ($this->pasaje->pasaje_vuelos as $this->pasaje_vuelo) {
            PasajeLiberacionHistorial::create([
                'pasaje_id'         => $this->pasaje->id,
                'pasaje_vuelo_anterior_id'   => $this->pasaje_vuelo->id,
                'codigo_historial'  => $codigo_liberacion,
                'approved_by_id' => $approved_by_id,
                'approved_observation' => $approved_observation,
                'nota'  => $this->nota
            ]);
        }

        $this->pasaje->pasaje_vuelos()->delete();

        $venta = Venta::create([
            'clientable_id' => $this->pasaje->pasajero_id,
            'clientable_type' => get_class($this->pasaje->pasajero)
        ]);

        // $tcs = new TasaCambioService();

        $venta->detalle()->create([
            'cantidad'      => 1,
            'descripcion'   => "Fecha abierta a pasaje - {$this->pasaje->codigo}",
            'monto'         => $monto_cambio_abierto,
            // 'monto_dolares' => $tcs->getMontoSoles($monto_cambio_abierto),
            // 'tasa_cambio'   => $tcs->tasa_cambio,
            'documentable_id'   => $this->pasaje->id,
            'documentable_type' => get_class($this->pasaje),
        ]);

        $this->pasaje->refresh();
        $this->pasaje->venta_detalle->update([
            'descripcion' => "Pasaje con fecha abierta - {$this->pasaje->vuelo_desc} - {$this->pasaje->nombre_short}"
        ]);

        $this->emit('pasajeChanged');
        $this->emit('notify', 'success', 'Liberado correctamente.');
    }
}
