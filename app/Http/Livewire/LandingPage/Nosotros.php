<?php

namespace App\Http\Livewire\LandingPage;

use App\Models\Oficina;
use Livewire\Component;

class Nosotros extends Component
{
    public function render() {
        return view('livewire.landing-page.nosotros', [
            'oficinas' => Oficina::get()
        ]);
    }
}
