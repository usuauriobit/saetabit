<?php

namespace App\Http\Livewire\LandingPage;

use App\Models\GuiaDespacho;
use Livewire\Component;

class Tracking extends Component {
    public GuiaDespacho $guia_despacho;
    // public $notFounded = false;
    public $listeners = [
        'guiaDespachoFounded' => 'setGuiaDespacho'
    ];

    public function render() {
        return view('livewire.landing-page.tracking');
    }

    public function setGuiaDespacho(GuiaDespacho $guia_despacho){
        $this->guia_despacho = $guia_despacho;
        // $this->notFounded = false;
    }
}
