<?php

namespace App\Http\Livewire\LandingPage\Components\AdquirirPasajesPage;

use App\Http\Livewire\LandingPage\Components\AdquirirPasajesPage\Traits\TarifaMontoTrait;
use Livewire\Component;

class TabRegistroPasajeros extends Component{
    use TarifaMontoTrait;

    public $tarifasIda= [];
    public $tarifasVuelta= [];

    public function render(){
        return view('livewire.landing-page.components.adquirir-pasajes-page.tab-registro-pasajeros');
    }
}
