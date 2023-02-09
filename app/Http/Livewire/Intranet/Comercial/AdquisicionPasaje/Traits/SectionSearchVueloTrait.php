<?php
namespace App\Http\Livewire\Intranet\Comercial\AdquisicionPasaje\Traits;

use App\Models\Ruta;
use App\Models\TipoVuelo;
use App\Models\Ubicacion;
use App\Models\Vuelo;
use Illuminate\Database\Eloquent\Collection;
use App\Services\VueloService;
trait SectionSearchVueloTrait{

    // EVENT LISTENERS ---------------------------------------------------
    public function setVuelosFounded(string $type_search, TipoVuelo $tipo_vuelo, Ubicacion $origen, Ubicacion $destino, array $ida_vuelos_founded_id, array $vuelta_vuelos_founded_id = null){
        $this->tipo_vuelo = $tipo_vuelo;
        $this->type_search = $type_search;
        $this->origen = $origen;
        $this->destino = $destino;
        $this->ida_vuelos_founded       =  Vuelo::find($ida_vuelos_founded_id)
                                            ->map(fn($v) => VueloService::generarVuelosAgrupados($v, $this->origen))
                                            ->toArray();
        $this->vuelta_vuelos_founded    = Vuelo::find($vuelta_vuelos_founded_id)
                                            ->map(fn($v) => VueloService::generarVuelosAgrupados($v, $this->destino))
                                            ->toArray();
        // dd($this->vuelta_vuelos_founded);
    }
    public function setVueloSelected($params){
        $this->{$params['type'].'_vuelos_selected'} = $this->{$params['type'].'_vuelos_founded'}[$params['index']];
        $this->isLibre = false;
        $this->pasajeros_libre = collect();
    }

    // PROPERTIES ---------------------------------------------------
    public function getIdaVuelosSelectedModelProperty(){
        return $this->_setVuelosSelectedModel('ida');
    }
    public function getVueltaVuelosSelectedModelProperty(){
        return $this->_setVuelosSelectedModel('vuelta');
    }
    private function _setVuelosSelectedModel($type){
        $vuelos = new Collection();
        if($this->{$type.'_vuelos_selected'} ){
            foreach ($this->{$type.'_vuelos_selected'} as $v) {
                $vuelos->push(Vuelo::find($v['id']));
            }
        }
        return $vuelos;
    }

    public function getHasAlreadyVueloSelectedProperty(){
        if($this->type_search == 'ida_vuelta')
            return !empty($this->ida_vuelos_selected) && !empty($this->vuelta_vuelos_selected);

        return !empty($this->ida_vuelos_selected);
    }
    // public function getAllVuelosSelectedModelProperty(){
    //     if($this->vuelta_vuelos_selected){
    //         return collect([
    //             'ida' => $this->ida_vuelos_selected_model,
    //             'vuelta' => $this->vuelta_vuelos_selected_model
    //         ]);
    //     }
    //     return collect([
    //         'ida' => $this->ida_vuelos_selected
    //     ]);
    // }
    public function getAllVuelosSelectedPlaneProperty(){
        return $this->ida_vuelos_selected_model->merge($this->vuelta_vuelos_selected_model);
        // dd($this->ida_vuelos_selected_model);

    }
    public function getIdaVuelosFoundedModelProperty(){
        return $this->_setVuelosFoundedModel('ida');
    }
    public function getVueltaVuelosFoundedModelProperty(){
        return $this->_setVuelosFoundedModel('vuelta');
    }
    private function _setVuelosFoundedModel($type){
        $vuelos = [];
        foreach ($this->{$type.'_vuelos_founded'} as $vuelo) {
            $vuelos[] = array_map(fn($v) => Vuelo::find($v['id']), $vuelo);
        }
        return $vuelos;
    }
}
?>
