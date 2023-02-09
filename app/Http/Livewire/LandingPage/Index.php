<?php

namespace App\Http\Livewire\LandingPage;

use App\Models\LPSeccionHero;
use Livewire\Component;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\JsonLd;
class Index extends Component {
    public $heroes;
    public function mount(){
        SEOMeta::setTitle("Vuelos");
        SEOMeta::setDescription('La empresa aérea líder en la amazonía peruana');
        SEOMeta::addMeta('article:section', 'landing page', 'property');
        SEOMeta::addKeyword([
            'saeta',
            'aerolínea',
            'empresa aérea',
            'amazonía peruana',
            'perú',
            'tarapoto',
            'vuelo',
            'barato',
            'descuento'
        ]);
        SEOMeta::setCanonical(env('APP_URL'));

        OpenGraph::setTitle('Vuelos');
        OpenGraph::setDescription('La empresa aérea líder en la amazonía peruana');
        OpenGraph::setUrl(env('APP_URL'));
        OpenGraph::addProperty('type', 'landing page');

        JsonLd::setTitle('SAETA');
        JsonLd::setDescription('La empresa aérea líder en la amazonía peruana');
        JsonLd::addImage(asset('img/logo-color.png'));

        $this->heroes = LPSeccionHero::get();
    }
    public function render() {
        return view('livewire.landing-page.index');
    }
}
