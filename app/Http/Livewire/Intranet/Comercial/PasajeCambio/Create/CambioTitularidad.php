<?php

namespace App\Http\Livewire\Intranet\Comercial\PasajeCambio\Create;

use App\Models\PasajeCambio;
use App\Models\Pasaje;
use App\Models\PasajeCambioTarifa;
use App\Models\Persona;
use App\Models\TipoPasajeCambio;
use App\Models\Venta;
use App\Services\TasaCambioService;
use Livewire\Component;

class CambioTitularidad extends Component
{
    public Pasaje $pasaje;
    public $pasaje_id;
    public $nueva_persona = null;
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
        'personaFounded' => 'setPersona',
        'passwordConfirmed' => 'saveCambioTitularidad'
    ];

    public function mount($pasaje_id){
        $this->pasaje_id = $pasaje_id;
        $this->pasaje = Pasaje::find($pasaje_id);

        $this->monto = PasajeCambioTarifa::whereHas('categoria_vuelo', function($q){
            return $q->where('descripcion', optional($this->pasaje->tipo_vuelo)->descripcion);
        })->first()->monto_cambio_titularidad ?? null;

        $this->tipo_pasaje_cambio_id = TipoPasajeCambio::whereDescripcion('Cambio de titular')->first()->id;
    }

    public function render(){
        return view('livewire.intranet.comercial.pasaje-cambio.create.cambio-titularidad');
    }

    public function eliminarPersona(){
        $this->nueva_persona = null;
    }
    public function setPersona(Persona $persona){
        if($persona->id == $this->pasaje->pasajero_id){
            $this->emit('notify', 'error', 'No se puede cambiar titularidad a la misma persona');
            return;
        }
        $this->nueva_persona = $persona;
    }
    public function saveCambioTitularidad($_ = null, $observacion = null, $userId = null){
        $this->approved_by_id = $userId;
        $this->approved_observation = $observacion;

        if(!$this->nueva_persona){
            $this->emit('notify','error', 'Selecciona el nuevo titular');
            return;
        }

        $data = $this->validate();

        $data['is_confirmado'] = true;
        $data['importe_penalidad'] = $this->is_sin_pagar ? 0 : $this->monto;

        $data = array_merge($data, [
            'pasajero_anterior_id'  => $this->pasaje->pasajero_id,
            'pasajero_nuevo_id'     => $this->nueva_persona->id
        ]);

        $cambio = PasajeCambio::create($data);
        // $tcs = new TasaCambioService();
        $venta = Venta::create([
            'clientable_id' => $cambio->pasajero_nuevo->id,
            'clientable_type' => get_class($cambio->pasajero_nuevo)
        ]);

        $venta->detalle()->create([
            'cantidad'      => 1,
            'descripcion'   => "Cambio de titular - Pasaje {$this->pasaje->codigo} (Anterior: "
                .optional($this->pasaje->pasajero)->nombre_short.") - (Nuevo: ".$this->nueva_persona->nombre_short.")",
            'monto'         => $cambio->importe_total,
            // 'monto_dolares' => $cambio->importe_penalidad,
            // 'tasa_cambio'   => $tcs->tasa_cambio,
            'documentable_id'   => $cambio->id,
            'documentable_type' => get_class($cambio),
        ]);

        $this->pasaje->update([
            'pasajero_id' => $this->nueva_persona->id
        ]);

        $this->pasaje->refresh();

        $this->pasaje->venta_detalle->update([
            'descripcion' => "Pasaje - {$this->pasaje->fecha_vuelo} - {$this->pasaje->vuelo_desc} - {$this->pasaje->nombre_short}"
        ]);

        $this->emit('pasajeCambioSetted');
        $this->emit('closeModals');
        $this->emit('notify','success', 'Se registró el cambio de titular correctamente');
    }

}
