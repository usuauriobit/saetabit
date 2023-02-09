<?php

namespace App\Http\Livewire\Intranet\Comercial\VueloCharter\Comercial;

use App\Models\Vuelo;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    public $nro_pagination = 10;
    public function render()
    {
        return view('livewire.intranet.comercial.vuelo-charter.comercial.index', [
            'items' => Vuelo::whereIsComercial()->paginate($this->nro_pagination)
        ]);
    }
}
