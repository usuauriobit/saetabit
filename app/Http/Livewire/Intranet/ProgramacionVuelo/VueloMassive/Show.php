<?php

namespace App\Http\Livewire\Intranet\ProgramacionVuelo\VueloMassive;

use App\Models\Vuelo;
use App\Models\VueloMassive;
use Livewire\Component;

class Show extends Component
{
  public VueloMassive $vuelo_massive;
  public $search = '';
  public $nro_pagination = 10;

  public function render()
  {
    $search = '%'.$this->search .'%';
    return view('livewire.intranet.programacion-vuelo.vuelo-massive.show', [
      'items' => Vuelo::whereVueloMassiveId($this->vuelo_massive->id)
      ->when(strlen($this->search) > 2, function($q) use ($search){
        return $q->searchFilter($q, $search);
      })
      ->orderBy('fecha_hora_vuelo_programado', 'asc')
      ->paginate($this->nro_pagination),
    ]);
  }

  public function destroy(){
    $can_eliminar_vuelo_massive = true;
    foreach ($this->vuelo_massive->vuelos as $vuelo) {
        if($vuelo->can_delete){
            $vuelo->delete();
        }else{
            $can_eliminar_vuelo_massive = false;
        }
    }
    if($can_eliminar_vuelo_massive){
        $this->vuelo_massive->delete();
    }
    return redirect()
        ->route('intranet.programacion-vuelo.vuelo-massive.index')
        ->with('success', 'Se eliminó correctamente');
  }
}
