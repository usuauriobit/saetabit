<?php

namespace App\Http\Livewire\LandingPage\Components\AdquirirPasajesPage;

use App\Http\Livewire\LandingPage\Components\AdquirirPasajesPage\Traits\TarifaMontoTrait;
use App\Models\Tarifa;
use App\Models\TipoPasaje;
use App\Services\TarifaService;
use App\Services\VueloService;
use Livewire\Component;

class SectionCosto extends Component {
    use TarifaMontoTrait;

    public $vuelos_ida_selected = [];
    public $vuelos_vuelta_selected = [];
    public $is_ida_vuelta;
    public $nro_pasajes;
    public $tarifas_ida = [];
    public $tarifas_vuelta = [];


    public function render() {
        $this->tarifas_ida = $this->vuelos_ida_selected
            ? TarifaService::calcularTarifas($this->vuelos_ida_selected, $this->nro_pasajes)
            : [];
        $this->tarifas_vuelta = $this->vuelos_vuelta_selected
            ? TarifaService::calcularTarifas($this->vuelos_vuelta_selected, $this->nro_pasajes)
            : [];
        return view('livewire.landing-page.components.adquirir-pasajes-page.section-costo');
    }

    public function getCanContinuarProperty(){
        $can_continuar = false;
        if(count($this->vuelos_ida_selected) > 0)
            $can_continuar = true;
        if($this->is_ida_vuelta && count($this->vuelos_vuelta_selected) == 0)
            $can_continuar = false;
        return $can_continuar;
    }

    public function continue(){
        if(!$this->can_continuar){
            $this->emit('notify', 'error', 'Complete correctamente el formulario');
            return;
        }

        foreach ($this->type as $type) {
            $has_asientos_disponibles = VueloService::vuelosHasAsientosDisponibles($this->{'vuelos_'.$type.'_selected'}, $this->{'tarifas_'.$type});

            if(!$has_asientos_disponibles){
                $error_msg = 'Ya no hay asientos disponibles para el vuelo de '.$type.' con la cantidad de pasajeros seleccionados';
                $this->emit('hasError', $error_msg);
                return;
            }
        }

        // Redireccion a registro de pasajero con los siguientes datos: ----------------------
        // Vuelos de ida
        // Vuelos de vuelta
        // Tarifas de ida
        // Tarifas de vueltas
        $params = $this->_generateParams();
        return redirect()->route('landing_page.registrar-pasajeros', $params);

        // return redirect()->route('landing_page.registrar-pasajeros', [
        //     'qs_vuelos_ida_selected_id' => collect($this->vuelos_ida_selected)->map(fn($i) => $i['id']),
        //     'qs_vuelos_vuelta_selected_id' => collect($this->vuelos_vuelta_selected)->map(fn($i) => $i['id']),
        //     'qs_tarifas_ida' => $this->tarifas_ida,
        //     'qs_tarifas_vuelta' => $this->tarifas_vuelta,
        // ]);
    }
    private function _generateParams() {
        $data = [
            'qs_vuelos_ida'     => collect($this->vuelos_ida_selected)->map(fn($el) => $el['codigo'])->toArray(),
            'qs_vuelos_vuelta'  => collect($this->vuelos_vuelta_selected)->map(fn($el) => $el['codigo'])->toArray(),
            'qs_tarifas_ida'    => collect($this->tarifas_ida)->map(fn($el) => [
                'nro' => $el['nro'],
                'descripcion' => $el['descripcion'],
            ])->toArray(),
            'qs_tarifas_vuelta' => count($this->tarifas_vuelta) > 0
                ? collect($this->tarifas_vuelta)->map(fn($el) => [
                    'nro' => $el['nro'],
                    'descripcion' => $el['descripcion'],
                ])->toArray()
                : []
        ];
        return $data;
    }
    public function getTypeProperty(){
        return $this->is_ida_vuelta ? ['ida', 'vuelta'] : ['ida'] ;
    }
}
