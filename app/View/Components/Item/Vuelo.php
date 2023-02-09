<?php

namespace App\View\Components\Item;

use Illuminate\View\Component;

class Vuelo extends Component
{
    public $vuelo;
    public function __construct($vuelo)
    {
        $this->vuelo = $vuelo;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.item.vuelo');
    }
}
