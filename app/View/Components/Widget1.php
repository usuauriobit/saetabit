<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Widget1 extends Component
{
    public $icon = '';
    public $title;
    public $value;
    public $result;
    public $diffValue;
    public $diffState;
    public $footer;
    public $diffIcon;
    public $footerDesc;
    public $footerValue;
    public $suffix;
    public $diffSuffix;
    public function __construct(
        $icon = '',
        $title,
        $value= null,
        $result = null,
        $diffValue = null,
        $diffIcon = '<i class="las la-caret-up"></i>',
        $diffState = 'danger',
        $footerDesc = 'Esperado',
        $footerValue = null,
        $footer = null,
        $suffix = '',
        $diffSuffix = '',
    )
    {
        $this->icon = $icon;
        $this->title = $title;
        $this->value = $value;
        $this->result = $result;
        $this->diffValue = $diffValue;
        $this->diffState = $diffState;
        $this->footer = $footer;
        $this->diffIcon = $diffIcon;
        $this->footerDesc = $footerDesc;
        $this->footerValue = $footerValue;
        $this->suffix = $suffix;
        $this->diffSuffix = $diffSuffix;
    }

    public function render()
    {
        return view('components.widget1');
    }
}
