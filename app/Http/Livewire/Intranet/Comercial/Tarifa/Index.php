<?php

namespace App\Http\Livewire\Intranet\Comercial\Tarifa;

use App\Models\Ruta;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Tarifa;
use App\Models\TipoVuelo;
use App\Models\Ubicacion;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $nro_pagination = 10;
    public $tarifa = null;
    public $items;
    public $ubicaciones = [];

	public $tarifa_edit = null;

    public $create_ruta = null;

    public $tab = 'comerciales';
    public $ubicacion_selected = [];

    public $listeners = [
        'tarifaUpdated' => 'getItems',
        'tarifaCreated' => 'getItems',
    ];

    public function mount(){
        $this->ubicaciones = Ubicacion::whereIsPermited()->with(['ubigeo'])->get();
        $this->ubicacion_selected = $this->ubicaciones[0]->id;
    }

    public function render() {
        $this->items = $this->getItems();
        return view('livewire.intranet.comercial.tarifa.index');
    }

    public function setTarifaCreate(Ruta $create_ruta){
        $this->create_ruta = $create_ruta;
        $this->emit('openModalCreateTarifa');
    }
    public function setTarifaEdit(Tarifa $tarifa){
        $this->tarifa_edit = $tarifa;
        $this->emit('openModalEditTarifa');
    }

    public function getItems(){
		$search = '%'.$this->search .'%';
        $this->items = Tarifa::latest()
        ->when(strlen($this->search) > 2, function($q) use ($search){
            return $q->whereHas("ruta", function($q) use ($search){
                return $q->whereHas("tramo", function($q) use ($search){
                    return $q->whereHas("origen", function($q) use ($search){
                        return $q->where('codigo_iata', 'ilike', $search)
                        ->orWhere('codigo_icao', 'ilike', $search)
                        ->orWhereHas('ubigeo', function($q) use ($search){
                            return $q->where('codigo', 'ilike', $search)
                            ->orWhere('departamento', 'ilike', $search)
                            ->orWhere('provincia', 'ilike', $search)
                            ->orWhere('distrito', 'ilike', $search);
                        });
                    })
                    ->orWhereHas("escala", function($q) use ($search){
                        return $q->where('codigo_iata', 'ilike', $search)
                        ->orWhere('codigo_icao', 'ilike', $search)
                        ->orWhereHas('ubigeo', function($q) use ($search){
                            return $q->where('codigo', 'ilike', $search)
                            ->orWhere('departamento', 'ilike', $search)
                            ->orWhere('provincia', 'ilike', $search)
                            ->orWhere('distrito', 'ilike', $search);
                        });
                    })
                    ->orWhereHas("destino", function($q) use ($search){
                        return $q->where('codigo_iata', 'ilike', $search)
                        ->orWhere('codigo_icao', 'ilike', $search)
                        ->orWhereHas('ubigeo', function($q) use ($search){
                            return $q->where('codigo', 'ilike', $search)
                            ->orWhere('departamento', 'ilike', $search)
                            ->orWhere('provincia', 'ilike', $search)
                            ->orWhere('distrito', 'ilike', $search);
                        });
                    });
                });
            })
            ->orWhere("precio", 'ilike', $search)
            ->orWhere("maximo_equipaje", 'ilike', $search)
            ->orWhere("descripcion", 'ilike', $search);
        })
        ->get();
    }
    public function destroy(Tarifa $tarifa){
        if(isset($tarifa->inverso)){
            $tarifa->inverso->delete();
        }
        $tarifa->delete();
        $this->emit('notify', 'success', 'Se eliminó correctamente 😃.');
    }
    public function getTipoVueloProperty(){
        switch ($this->tab) {
            case 'comerciales':
                return TipoVuelo::whereIsComercial()->first();
            case 'subvencionados':
                return TipoVuelo::whereIsSubvencionado()->first();
            default:
                return TipoVuelo::whereIsNotRegular()->first();
                break;
        }
    }
    public function getRutasProperty(){
		$rutas = \App\Models\Ruta::where('tipo_vuelo_id', $this->tipo_vuelo->id)
                ->whereHas('tramo', function($q){
                    $q->where('origen_id', $this->ubicacion_selected);
                })
                ->with([
                    'tipo_vuelo',
                    'tramo',
                    'tramo.origen',
                    'tramo.escala',
                    'tramo.destino',
                    'tramo.origen.ubigeo',
                    'tramo.escala.ubigeo',
                    'tramo.destino.ubigeo',
                    'tarifas',
                    'tarifas.tipo_pasaje',
                ])
                ->get();
        return $rutas;
    }
    public function setTab($tab){
        $this->tab = $tab;
    }
    public function setUbicacionSelected($id){
        $this->ubicacion_selected = $id;
    }
}
