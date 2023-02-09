<?php
namespace App\Http\Livewire\Intranet\Comercial\Vuelo\ConsultaTrait;

use App\Models\Descuento;
use App\Models\Pasaje;
use App\Models\Ruta;
use App\Models\Tarifa;
use App\Models\Ubicacion;
use App\Models\Vuelo;
use App\Services\DescuentoService;
use Illuminate\Support\Facades\Auth;

trait Properties{



    public function getOrigenProperty(){
        return !is_null($this->form['origen_id']) ? Ubicacion::find($this->form['origen_id']) : null;
    }
    public function getDestinoProperty(){
        return !is_null($this->form['destino_id']) ? Ubicacion::find($this->form['destino_id']) : null;
    }
    public function getVuelosFoundedModelProperty(){
        $vuelos = collect(['ida' => collect(), 'vuelta' => collect()]);
        foreach ($this->vuelos_founded as $type => $vuelos_founded)
            foreach ($vuelos_founded as $v)
                $vuelos[$type]->push($this->generarVuelosAgrupados(Vuelo::find($v['id'])));
        return $vuelos;
    }

    public function getTipoDescuentoVuelosProperty(){
        $ruta_id = null;
        if($this->form['type'] == 'ida_vuelta')
            $ruta_id = optional($this->ruta_first)->id;
        return Descuento::whereAvailable('Vuelo', $ruta_id)->get();
    }
    public function getMontoPasajesProperty(){
        $monto_total = 0;
        foreach ($this->pasajes_model as $t => $pasajes)
            $monto_total += $pasajes->sum('importe_final');

        return $monto_total;
    }
    public function getMontoDescuentoGeneralProperty(){
        if($this->descuento_general){
            return DescuentoService::calcularValorDescuento($this->monto_pasajes, $this->descuento_general);
        }
        return 0;
    }
    public function getMontoFinalProperty(){
        $monto_final = 0;
        $monto_final += $this->monto_pasajes;
        $monto_final -= $this->monto_descuento_general;

        return $monto_final;
    }
    public function getCanDescuentoGeneralProperty(){
        if($this->monto_pasajes == 0 || $this->tipo_descuento_vuelos->count() == 0){
            $this->descuento_general = null;
            return false;
        }
        return true;
    }
    public function getIsWithDescuentoProperty(){
        return (bool) $this->descuento_general;
    }
    public function getIsWithVentaProperty(){
        // return ((int) $this->monto_final) > 0;
        return !(optional($this->tipo_vuelo)->is_charter);
    }
    public function getMontoAhorradoVentaGeneralProperty(){
        return $this->monto_pasajes - $this->monto_final ;
    }

    public function getPasajesModelProperty(){
        $pasajes = collect(['ida' => collect()]);
        if($this->form['type'] == 'ida_vuelta')
            $pasajes['vuelta'] = collect();

        foreach ($this->vuelos_selected_model as $type => $v){
            foreach ($this->pasajes as $pasaje) {

                // OBTENER RUTA
                 $ruta = $this->getRutaByVuelo($v);
                // BUSCAR TARIFA POR RUTA
                $tarifa = Tarifa::where('ruta_id', $ruta->id ?? null)
                            ->where('tipo_pasaje_id', $pasaje['tipo_pasaje']['id'])
                            ->first();

                $pasaje_t = new Pasaje([
                    'tarifa_id'     => $tarifa['id'],
                    'tipo_pasaje_id' => $pasaje['tipo_pasaje']['id'],
                    'descuento_id' => $pasaje['descuento_id'] ?? null,
                    'pasajero_id'    => $pasaje['persona_id'],
                    'oficina_id'    => Auth::user()->personal->oficina_id,
                    'importe'       => $tarifa['precio'],
                    'telefono'      => $pasaje['telefono'] ?? null,
                    'email'         => $pasaje['email'] ?? null,
                    'descripcion'   => $pasaje['descripcion'] ?? null,
                    'peso_persona'  => $pasaje['peso_estimado'] ?? null,
                    'fecha'         => $pasaje['fecha'] ?? null,
                    'is_asistido'   => false,
                    'is_compra_web' => false,
                ]);
                $pasaje_t->temporal_id = $pasaje['temporal_id'].$type;
                $pasajes[$type]->push($pasaje_t);
            }
        }
        return $pasajes;
    }
    public function getVuelosSelectedModelProperty(){
        $vuelos = collect(['ida' => collect()]);
        if($this->form['type'] == 'ida_vuelta')
            $vuelos['vuelta'] = collect();

        foreach ($this->vuelos_selected as $type => $vuelos_selected){
            $vuelos_generados = array_map( fn($d) => Vuelo::find($d['id']) , $vuelos_selected);
            $vuelos[$type] = $vuelos_generados;
        }

        return $vuelos;
    }

    public function getRutaFirstProperty(){
        $v = $this->vuelos_selected_model['ida'];
        \Debugbar::info(['Abajo', $v]);
        return $this->getRutaByVuelo($v);
    }

    private function getRutaByVuelo($v){
        return Ruta::whereTipoVueloId($v[0]['tipo_vuelo_id'])
            ->whereHas('tramo', function($q) use ($v){
                $q->where('origen_id', $v[0]['origen_id'])
                ->where('escala_id', $v[1]['origen_id'] ?? null)
                ->where('destino_id', $v[1]['destino_id'] ?? $v[0]['destino_id']);
            })->first();
    }
}
?>
