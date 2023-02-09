<?php

namespace App\Http\Livewire\Intranet\Comercial\AdquisicionPasaje;

use App\Models\Pasaje;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $nro_pagination = 10;
    public $origen = '';
    public $destino = '';
    public $desde = '';
    public $hasta = '';

    public $filterSelected = 'todos';
    public $filterOptions = [
        [
            'id' => 'todos',
            'descripcion' => 'Todos',
        ],
        [
            'id' => 'sin_asignar_vuelo',
            'descripcion' => 'Sin vuelo asignado',
        ],
        [
            'id' => 'asignados_vuelo',
            'descripcion' => 'Asignados a un vuelo',
        ],
        [
            'id' => 'pasajes_sin_volar',
            'descripcion' => 'Pasajes sin volar',
        ],
        [
            'id' => 'pasajes_han_volado',
            'descripcion' => 'Pasajes que ya han volado',
        ],
    ];

    public function mount() {
        $this->desde = date('Y-m-d');
        $this->hasta = date('Y-m-d');
    }

    public function render() {
        return view('livewire.intranet.comercial.adquisicion-pasaje.index',[
            'items' => $this->getItems(),
        ]);
    }
    public function getItems() {
        return Pasaje::latest()->filter(
                        $this->search,
                        $this->filterSelected,
                        $this->origen,
                        $this->destino,
                        $this->desde,
                        $this->hasta,
                    )
                ->paginate($this->nro_pagination);
    }
}
