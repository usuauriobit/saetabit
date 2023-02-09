<?php

namespace App\Http\Livewire\Intranet\Mantenimiento\TiempoAvionTramo;

use App\Models\Avion;
use App\Models\TiempoAvionTramo;
use App\Models\TiempoTramo;
use App\Models\Tramo;
use Livewire\Component;

class Create extends Component {
    public TiempoAvionTramo|null $tiempo_avion_tramo;
    public Avion|null $avion;
    public $form = [
        'tiempo_vuelo' => null,
    ];
    public $tramo_selected = null;
    public $listeners = [
        'tramoSelected' => 'selectTramo',
    ];
    public function mount(){
        if(isset($this->tiempo_avion_tramo)){
            $this->form['tiempo_vuelo'] = $this->tiempo_avion_tramo->tiempo_vuelo;
        }
    }
    public function render() {
        return view('livewire.intranet.mantenimiento.tiempo-avion-tramo.create');
    }

    public function selectTramo(Tramo $tramo){
        $this->tramo_selected = $tramo;
    }
    public function save(){
        $this->validate([
            'form.tiempo_vuelo' => 'required|numeric',
        ]);
        // dd($this->tiempo_avion_tramo->tiempo_vuelo, $this->tiempo_avion_tramo->avion_id);
        TiempoAvionTramo::where('tiempo_vuelo', $this->tiempo_avion_tramo->tiempo_vuelo)
            ->where('avion_id', $this->tiempo_avion_tramo->avion_id)
            ->update([
                'tiempo_vuelo' => $this->form['tiempo_vuelo'],
            ]);
        return redirect()->route('intranet.mantenimiento.avion.show', $this->tiempo_avion_tramo->avion_id)->with('success', 'Tiempo de vuelo actualizado correctamente');
    }
    public function store(){
        if(!$this->tramo_selected){
            $this->emit('notify', 'error', 'Debe seleccionar un tramo');
            return;
        }
        $this->validate([
            'form.tiempo_vuelo' => 'required|numeric',
        ]);
        $tiempo_avion_tramo_exist = TiempoAvionTramo::where('avion_id', $this->avion->id)
            ->where('tramo_id', $this->tramo_selected->id)
            ->first();
        if($tiempo_avion_tramo_exist){
            $this->emit('notify', 'error', 'Ya existe un tiempo de vuelo para este avión y tramo');
            return;
        }
        $this->avion->tiempo_avion_tramos()->create([
            'tramo_id' => $this->tramo_selected->id,
            'tiempo_vuelo' => $this->form['tiempo_vuelo'],
        ]);
        $this->avion->tiempo_avion_tramos()->create([
            'tramo_id' => $this->tramo_selected->inverso->id,
            'tiempo_vuelo' => $this->form['tiempo_vuelo'],
        ]);
        return redirect()->route('intranet.mantenimiento.avion.show', $this->avion->id)->with('success', 'Tiempo de vuelo registrado correctamente');
    }
    public function deleteTramo(){
        $this->tramo_selected = null;
    }
}
