<?php

namespace App\Http\Livewire\Intranet\Mantenimiento\LandingPage\SeccionHero;

use App\Models\LPSeccionHero;
use Livewire\Component;

class Index extends Component {
    public function render() {
        $heroes = LPSeccionHero::get();
        return view('livewire.intranet.mantenimiento.landing-page.seccion-hero.index', [
            'heroes' => $heroes
        ]);
    }
    public function delete(LPSeccionHero $hero){
        $hero->delete();
        $this->emit('notify', 'success', 'Se eliminó correctamente');
    }
}
