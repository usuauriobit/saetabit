<?php

namespace App\View\Components\Master;

use Illuminate\View\Component;

class Datatable extends Component
{
    public $count;
    public $total;
    public $actions;
    public $items;
    public $compact;
    public function __construct(
        $count = 0,
        $total = 0,
        $actions = null,
        $items = [],
        $compact = null,
    )
    {
        $this->count = $count;
        $this->total = $total;
        $this->actions = $actions;
        $this->items = $items;
        $this->compact = $compact;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.master.datatable');
    }
}
