<?php

namespace App\View\Components\Master;

use Illuminate\View\Component;

class Modal extends Component
{
    public $idModal;
    public $wSize;
    public $label;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($idModal = null, $wSize = null, $label = null)
    {
        $this->idModal = !is_null($idModal) ? $idModal : now().".";
        $this->wSize = $wSize;
        $this->label = $label;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.master.modal');
    }
}
