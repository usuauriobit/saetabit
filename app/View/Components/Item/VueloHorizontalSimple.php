<?php

namespace App\View\Components\Item;

use App\Models\Vuelo;
use App\Services\PasajeService;
use Illuminate\View\Component;

class VueloHorizontalSimple extends Component
{
    public Vuelo $vueloOrigen;
    public Vuelo $vueloDestino;
    public $vuelos = [];
    public $hasEscala = false;
    public $transparent = false;
    public $asientos_disponibles = 0;
    public $showInfo = true;
    public $hideAsientosDisponibles = false;
    public $hideCodigo = false;

    public function __construct($vuelos, $transparent = false, $hideAsientosDisponibles = false, $hideCodigo = false)
    {
        $this->transparent = $transparent;
        $this->hideAsientosDisponibles = $hideAsientosDisponibles;
        $this->hideCodigo = $hideCodigo;

        $this->vuelos = $vuelos;
        $this->vueloOrigen = $this->vuelos[0];
        $this->vueloDestino = count($this->vuelos) == 1
                                ? $this->vueloOrigen
                                : $this->vuelos[1];
        if(count($this->vuelos) > 1)
            $this->hasEscala = true;

        $this->asientos_disponibles = PasajeService::getNroAsientosDisponiblesByVuelos( is_array($this->vuelos) ? $this->vuelos : $this->vuelos->toArray());
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.item.vuelo-horizontal-simple');
    }
}
