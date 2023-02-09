<?php

namespace App\View\Components\Master;

use Illuminate\View\Component;

class Select extends Component
{
    public $bordered            ;
    public $ghost               ;
    public $helperTop           ;
    public $altLabelBL        ;
    public $brandColorPrimary   ;
    public $brandColorSecondary ;
    public $brandColorAccent    ;
    public $sizeLg               ;
    public $sizeSm               ;
    public $sizeXs               ;
    public $label               ;
    public $name                ;
    public $desc                ;
    public $val                 ;
    public $options             ;
    public function __construct(
        $bordered            = true,
        $ghost               = false,
        $helperTop           = null,
        $altLabelBL        = null,
        $brandColorPrimary   = false,
        $brandColorSecondary = false,
        $brandColorAccent    = false,
        $sizeLg               = false,
        $sizeSm               = false,
        $sizeXs               = false,
        $label               = null,
        $name                = null,
        $desc                = 'descripcion',
        $val                 = 'id',
        $options             = []
    )
    {
        $this->bordered             = $bordered;
        $this->ghost                = $ghost;
        $this->helperTop            = $helperTop;
        $this->altLabelBL         = $altLabelBL;
        $this->brandColorPrimary    = $brandColorPrimary;
        $this->brandColorSecondary  = $brandColorSecondary;
        $this->brandColorAccent     = $brandColorAccent;
        $this->sizeLg                = $sizeLg;
        $this->sizeSm                = $sizeSm;
        $this->sizeXs                = $sizeXs;
        $this->label                = $label;
        $this->name                 = $name;
        $this->desc                 = $desc;
        $this->val                  = $val;
        $this->options               = $options;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.master.select');
    }
}
