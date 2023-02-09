<?php

namespace App\View\Components\Item;

use Illuminate\View\Component;

class VueloEscala extends Component
{
    public $vueloOrigen;
    public $vueloDestino;
    public function __construct($vueloOrigen, $vueloDestino)
    {
        $this->vueloOrigen = $vueloOrigen;
        $this->vueloDestino = $vueloDestino;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.item.vuelo-escala');
    }
}
