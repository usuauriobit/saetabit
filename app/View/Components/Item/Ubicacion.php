<?php

namespace App\View\Components\Item;

use App\Models\Ubicacion as ModelsUbicacion;
use Illuminate\View\Component;

class Ubicacion extends Component
{
    public $ubicacion;
    public $title;
    public $actions;
    public $onlyDistrito;
    public $hideCodigo;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        $ubicacion,
        String $title = '',
        $actions = '',
        $onlyDistrito = false,
        $hideCodigo = false
    )
    {
        $this->ubicacion    = $ubicacion;
        $this->title        = $title;
        $this->actions      = $actions;
        $this->onlyDistrito = $onlyDistrito;
        $this->hideCodigo   = $hideCodigo;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.item.ubicacion');
    }
}
