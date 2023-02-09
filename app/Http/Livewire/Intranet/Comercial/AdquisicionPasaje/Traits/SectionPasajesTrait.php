<?php
namespace App\Http\Livewire\Intranet\Comercial\AdquisicionPasaje\Traits;

use App\Models\Descuento;
use App\Models\Pasaje;
use App\Models\Ruta;
use App\Models\Tarifa;
use App\Services\DescuentoService;
use Illuminate\Support\Facades\Auth;
use App\Services\PasajeService;

trait SectionPasajesTrait{
    public function addPasaje($data){
        // VALIDAR QUE EL PASAJERO NO TENGO YA UN PASAJE EN ESTA RELACION DE VUELOS
        $hasAlreadyPasajes = $this->_validatePasajeroAlreadyHasPasajeInVuelos($data['persona_id']);
        if($hasAlreadyPasajes){
            $this->emit('notify','error', 'La persona ya tiene pasajes en el grupo de vuelos seleccionados');
            return;
        }

        if($this->isLibre){
            $ruta = $this->_getRutaByData(tipo_vuelo_id:$this->tipo_vuelo->id, origen_id:$this->origen->id, destino_id:$this->destino->id );

            if(!$ruta){
                $this->emit('notify','error', 'No se encontró ruta con los filtros seleccionados');
                return;
            }
            // VALIDAR SI HAY TARIFA PARA EL TIPO DE PASAJE EN LA RUTA
            $tarifa = Tarifa::where('ruta_id', $ruta->id ?? null)
                    ->where('tipo_pasaje_id', $data['tipo_pasaje']['id'])
                    ->first();
            if(!$tarifa){
                $this->emit('notify', 'error', 'No existe tarifa para este tipo de pasajero en esta ruta de vuelo');
                return;
            }
            $pasaje_t = $this->_createTemporalPasaje(data:$data, tarifa: $tarifa);
            $this->pasajeros_libre->add($pasaje_t);
            return;
        }


        foreach ($this->available_types as $type) {
            $v = $this->{$type.'_vuelos_selected_model'};
            $ruta = $this->getRutaByVuelo($v);

            // SI ES VUELO CHARTER NO ES NECESARIO BUSCAR TARIFA, YA QUE SE PAGA TODO EL VUELO
            $tarifa = null;
            if(!$this->tipo_vuelo->is_charter && !$this->tipo_vuelo->is_compania){
                // VALIDAR SI HAY TARIFA PARA EL TIPO DE PASAJE EN LA RUTA
                $tarifa = Tarifa::where('ruta_id', $ruta->id ?? null)
                        ->where('tipo_pasaje_id', $data['tipo_pasaje']['id'])
                        ->first();
                if(!$tarifa){
                    $this->emit('notify', 'error', 'No existe tarifa para este tipo de pasajero en esta ruta de vuelo');
                    return;
                }
            }

            $pasaje_t = $this->_createTemporalPasaje(data:$data, tarifa:$tarifa, vuelos: $v);

            $this->{$type.'_pasajes'}->add($pasaje_t);
        }
    }

    private function _createTemporalPasaje($data, Tarifa|null $tarifa = null, $vuelos = null) {
        $pasaje_t = new Pasaje([
            'tarifa_id'     => $tarifa['id'] ?? null,
            'tipo_pasaje_id'=> $data['tipo_pasaje']['id'],
            'descuento_id'  => $data['descuento_id'] ?? null,
            'pasajero_id'   => $data['persona_id'],
            'oficina_id'    => Auth::user()->personal->oficina_id,
            'importe'       => $tarifa['precio'] ?? 0,
            'telefono'      => $data['telefono'] ?? null,
            'email'         => $data['email'] ?? null,
            'descripcion'   => $data['descripcion'] ?? null,
            'peso_persona'  => $data['peso_estimado'] ?? null,
            'fecha'         => $data['fecha'] ?? null,
            'is_asistido'   => false,
            'is_compra_web' => false,
        ]);
        $pasaje_t->temporal_id = uniqid();


        return $pasaje_t;
    }
    public function test(){

    }
    // public function getDescuentosFromPasaje($pasaje, $vuelo_origen){
    //     $descuento_instance = new DescuentoService(
    //         vuelo_origen: $vuelo_origen,
    //         tarifa      : $pasaje->tarifa,
    //         is_ida_vuelta: false,
    //         tipoPasaje  : $pasaje->tipo_pasaje,
    //         persona     : $pasaje->pasajero
    //     );
    //     $descuentos = $descuento_instance->getDescuentosRestantes();
    //     return $descuentos;

    // }

    private function getRutaByVuelo($v){
        return Ruta::whereTipoVueloId($v[0]['tipo_vuelo_id'])
            ->whereHas('tramo', function($q) use ($v){
                $q->where('origen_id', $v[0]['origen_id'])
                ->where('escala_id', $v[1]['origen_id'] ?? null)
                ->where('destino_id', $v[1]['destino_id'] ?? $v[0]['destino_id']);
            })->first();
    }

    private function _getRutaByData($tipo_vuelo_id, $origen_id, $destino_id){
        return Ruta::whereTipoVueloId($tipo_vuelo_id)
            ->whereHas('tramo', function($q) use ($origen_id, $destino_id){
                $q->where('origen_id',$origen_id)
                // ->where('escala_id',  ?? null)
                ->where('destino_id', $destino_id);
            })->first();
    }

    public function getAllPasajesProperty(){
        $data = collect();
        foreach ($this->available_types as $type)
            $data[$type] = collect($this->{$type.'_pasajes'});
        return $data;
    }
    public function getAllPasajesPlaneProperty(){
        if($this->isLibre){
            return $this->pasajeros_libre;
        }else{
            $pasajes = collect();
            foreach($this->ida_pasajes as $pasaje){
                $pasajes->push($pasaje);
            }
            foreach($this->vuelta_pasajes as $pasaje){
                $pasajes->push($pasaje);
            }
            return $pasajes;
        }
    }

    public function hydratePasajerosLibre($data){
        return $this->rehydratarPasajes($data);
    }
    public function hydrateIdaPasajes($data){
        return $this->rehydratarPasajes($data);
    }
    public function hydrateVueltaPasajes($data){
        return $this->rehydratarPasajes($data);
    }
    private function rehydratarPasajes($data){
        foreach ($data as $index => $pasaje) {
            $pasaje_array = (array) $pasaje;
            unset($pasaje_array['descuento']);
            $data[$index] = new Pasaje($pasaje_array);
            $data[$index]->temporal_id = $pasaje_array['temporal_id'];
        }
        return $data;
    }
    public function asignarDescuentoPasaje($temporal_id, Descuento $descuento){
        $pos = $this->_findPasajePosition($temporal_id);
        // dd($this->{$pos['type'].'_pasajes'}[$pos['index']]);
        $this->{$pos['type'].'_pasajes'}[$pos['index']]->descuento_id = $descuento->id;
    }
    public function quitarDescuentoPasaje($temporal_id){
        $pos = $this->_findPasajePosition($temporal_id);
        $this->{$pos['type'].'_pasajes'}[$pos['index']]->descuento_id = null;
    }
    public function deletePasaje($temporal_id){
        $pos = $this->_findPasajePosition($temporal_id);

        if($this->isLibre){
            unset($this->pasajeros_libre[$pos['index']]);
        }else{
            unset($this->{$pos['type'].'_pasajes'}[$pos['index']]);
        }
    }
    private function _findPasajePosition($temporal_id){

        if($this->isLibre){
            foreach ($this->pasajeros_libre as $index => $pasaje) {
                if($pasaje->temporal_id == $temporal_id)
                    return ['index' => $index];
            }
        }else{
            foreach ($this->available_types as $type){
                foreach ($this->{$type.'_pasajes'} as $index => $pasaje) {
                    if($pasaje->temporal_id == $temporal_id)
                        return ['type' => $type, 'index' => $index];
                }
            }
        }
    }
    public function getHasPasajesProperty(){
        if($this->isLibre)
            return (bool) $this->pasajeros_libre->count();

        return (bool) $this->all_pasajes->reduce(fn($carry, $type) => $carry + count($type));
    }

    public function getCanAddPasajesProperty(){
        // dd($this->nro_asientos_disponibles);
        return $this->nro_asientos_disponibles > 0 || $this->isLibre;
    }
    public function getNroAsientosDisponiblesProperty(){
        return $this->getNroAsientosDisponibles();
    }
    public function getNroAsientosDisponibles(){
        $cantidad_por_registrar = collect($this->ida_pasajes)->reduce(fn($carry, $pasaje) => $carry += ($pasaje->ocupa_asiento ? 1 : 0));
        $cantidad_por_registrar += collect($this->vuelta_pasajes)->reduce(fn($carry, $pasaje) => $carry += ($pasaje->ocupa_asiento ? 1 : 0));
        return PasajeService::getNroAsientosDisponiblesByVuelos($this->all_vuelos_selected_plane->toArray(), $cantidad_por_registrar);
    }
    private function _validatePasajeroAlreadyHasPasajeInVuelos($persona_id){
        $vuelos_id = $this->all_vuelos_selected_plane->map(fn($i) => $i->id);
        $hasAlreadyPasajes = PasajeService::pasajeroAlreadyHasPasajeInVuelos($persona_id, $vuelos_id);

        foreach ($this->all_pasajes_plane as $pasaje) {
            if($pasaje['pasajero_id'] == $persona_id) {
                $hasAlreadyPasajes = true;
                break;
            }
        }

        return $hasAlreadyPasajes;
    }

    public function getHaveToApproveProperty(){
        $has = false;

        if(
            !$this->tipo_vuelo->is_comercial
            // $this->tipo_vuelo->is_no_regular &&
            // $this->tipo_vuelo->is_subvenionado
        ){
            return false;
        }

        foreach ($this->all_pasajes_plane as $pasaje) {
            if($pasaje->importe_final_calc == 0)
                return true;
        }
        return $has;
    }
}
?>
