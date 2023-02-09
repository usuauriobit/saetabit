<?php

namespace App\View\Components\Item;

use Illuminate\View\Component;

class Ruta extends Component
{
    public $ruta;
    public $isSimple;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($ruta, $isSimple = false)
    {
        $this->ruta = $ruta;
        $this->isSimple = $isSimple;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.item.ruta');
    }
}
