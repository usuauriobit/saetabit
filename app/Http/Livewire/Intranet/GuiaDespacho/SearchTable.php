<?php

namespace App\Http\Livewire\Intranet\GuiaDespacho;

use App\Models\GuiaDespacho;
use Livewire\Component;

class SearchTable extends Component
{
    public $search;
    public $nro_pagination = 10;
    public $ubicacionId;
    public function render()
    {
        $search = '%'.$this->search .'%';
        return view('livewire.intranet.guia-despacho.search-table', [
            'items' => GuiaDespacho::latest()
            // La carga está en almacén de origen y este almacén coincide
            // con la ubicación de origen del vuelo.
            ->orWhere(function($q){
                return $q->whereDoesntHave('guia_despacho_steps')
                    ->where('origen_id', $this->ubicacionId);
            })
            // La carga está ya está en camino y se encuentra en el almacén
            // de otra ubicación y el origen del vuelo coincide con esa ubicación.
            ->whereHas('guia_despacho_steps', function($q){
                return $q->whereHas('vuelo', function($q){
                    return $q->whereDestinoId($this->ubicacionId)
                        ->whereNotNull('hora_aterrizaje');
                });
            })
            ->when(strlen($this->search) > 2, function($q) use ($search){
                return $q->filter($search);
            })

            // La carga no se encuentra en la ubicación de destino aún.

            // La carga no ha sido entregada aún.

            // El vuelo que cumpla con estos criterios tampoco debe aparecer
            // como vuelo cerrado.

            ->whereNull('fecha_entrega')
            ->paginate($this->nro_pagination),
        ]);
    }

    public function setGuiaDespacho($guia_despacho_id){
        $this->emit('guiaDespachoSetted', $guia_despacho_id);
    }
}
