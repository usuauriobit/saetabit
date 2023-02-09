<?php

namespace App\Http\Livewire\Intranet\Caja\Caja;

use App\Models\Caja;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Index extends Component
{
    public $search = '';
    public function render()
    {
        $search = '%'.$this->search .'%';
        return view('livewire.intranet.caja.caja.index', [
            'items' => Auth::user()->personal->cajas
        ]);
    }
}
