<?php

namespace App\View\Components\Master;

use Illuminate\View\Component;

class Item extends Component
{
    public $avatar;
    public $label;
    public $sublabel;
    public $actions;
    public $labelSize;
    public $noPadding;
    public function __construct(
        $avatar     = null,
        $label      = null,
        $sublabel   = null,
        $actions    = null,
        $labelSize  = 'md',
        $noPadding  = false,
    )
    {
        $this->avatar   = $avatar;
        $this->label    = $label;
        $this->sublabel = $sublabel;
        $this->actions  = $actions;
        $this->labelSize  = $labelSize;
        $this->noPadding  = $noPadding;
    }

    public function render()
    {
        return view('components.master.item');
    }
}
