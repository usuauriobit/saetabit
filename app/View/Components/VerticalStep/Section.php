<?php

namespace App\View\Components\VerticalStep;

use Illuminate\View\Component;

class Section extends Component
{
    public $title;
    public $action;
    public $description;

    public function __construct($title = '', $action = '', $description = '')
    {
        $this->title = $title;
        $this->action = $action;
        $this->description = $description;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.vertical-step.section');
    }
}
