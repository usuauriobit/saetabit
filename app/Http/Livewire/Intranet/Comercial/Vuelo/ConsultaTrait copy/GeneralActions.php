<?php
namespace App\Http\Livewire\Intranet\Comercial\Vuelo\ConsultaTrait;

use App\Models\Descuento;
use App\Models\Vuelo;

trait GeneralActions{


    public function deletePasajeroByIndex($index){
        array_splice($this->pasajes, $index, 1);
    }
    public function removeCliente(){
        $this->cliente = null;
    }
    public function deleteUbicacion($type){
        if($type == 'destino')
            $this->form['destino_id'] = null;
        if($type == 'origen')
            $this->form['origen_id'] = null;
    }
    public function selectVuelo($index, $type){
        $this->vuelos_selected[$type] = $this->vuelos_founded_model[$type][$index];

        \Debugbar::info('Vuelos seleccionados', $this->vuelos_selected);
    }
    public function generarVuelosAgrupados(Vuelo $vuelo){
        if($vuelo->origen_id == $this->form['origen_id'])
            return [$vuelo];

        return [$vuelo->vuelo_anterior, $vuelo];
    }
    public function searchVuelos(){
        $data = $this->validate([
            'form.destino_id' => 'required',
            'form.origen_id' => 'required',
            'form.fecha_ida' => 'required',
            'form.fecha_vuelta' => $this->form['type'] == 'solo_ida' ? 'nullable' : 'required',
            'form.tipo_vuelo_id' => 'required',
        ])['form'];

        $this->vuelos_founded['ida'] = Vuelo::searchVuelosInRuta($data)->get();
        if(count($this->vuelos_founded['ida']) == 0)
            $this->emit('notify','error','No se encontraron vuelos de ida. Pruebe con una fecha distinta');

        if($this->form['type'] == 'ida_vuelta'){
            $this->vuelos_founded['vuelta'] = Vuelo::searchVuelosInRuta([
                'destino_id' => $data['origen_id'],
                'origen_id' => $data['destino_id'],
                'fecha_ida' => $data['fecha_ida'],
            ])->get();
            if(count($this->vuelos_founded['vuelta']) == 0)
                $this->emit('notify','error','No se encontraron vuelos de vuelta. Pruebe con una fecha distinta');
        }
    }



    // DESCUENTOS -------------------------------------------------------------------
    // DESCUENTOS - PASAJE -------------------------------------------------------------------
    public function asignarDescuentoPasaje($type, $pasaje_uid, $descuento_id){
        foreach ($this->pasajes as $index => $pasaje_array) {
            if($pasaje_array['temporal_id'] == $pasaje_uid){
                $this->pasajes[$index]['descuento_id'] = $descuento_id;
            }
        }
    }
    public function quitarDescuentoPasaje($pasaje_uid){
        foreach ($this->pasajes as $index => $pasaje_array) {
            if($pasaje_array['temporal_id'] == $pasaje_uid){
                $this->pasajes[$index]['descuento_id'] = null;
            }
        }
    }
    // DESCUENTOS - VENTA -------------------------------------------------------------------
    public function asignarDescuentoGeneral(Descuento $descuento){
        $this->descuento_general = $descuento;
    }
    public function quitarDescuentoGeneral($pasaje_uid){
        $this->descuento_general = null;
    }
}
