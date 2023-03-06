<?php

namespace App\Http\Livewire\Intranet\Caja\CajaAperturaCierre;

use App\Models\CajaAperturaCierre;
use App\Models\Oficina;
use App\Models\Personal;
use App\Models\TipoCaja;
use Livewire\WithPagination;
use Livewire\Component;
use PDF;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $oficina_id = null;
    public $desde = null;
    public $hasta = null;
    public $cajero_id = null;
    public $tipo_caja_id = null;
    public $nro_pagination = 10;

    public function mount()
    {
        $this->oficinas = Oficina::get();
        $this->cajeros = Personal::has('cajas')->get();
        $this->tipo_cajas = TipoCaja::get();
        $this->desde = date('Y-m-d');
        $this->hasta = date('Y-m-d');
    }

    public function render()
    {
        $search = '%'.$this->search .'%';

        return view('livewire.intranet.caja.caja-apertura-cierre.index', [
            'items' => CajaAperturaCierre::latest()
                    ->whereNotNull("fecha_cierre")
                    // ->when(strlen($this->search) > 2, function($q) use ($search){
                    //     return $q
                    //     ->orWhereHas("caja", function($q) use ($search){
                    //         return $q->where("descripcion", 'ilike', $search);
                    //     })
                    //     ->orWhereHas("user_created.personal.persona", function($q) use ($search){
                    //         return $q->whereRaw("CONCAT(nombres, ' ', apellido_paterno, ' ', apellido_materno) LIKE ?", [$search]);
                    //     })
                    //     ->orWhere("fecha_apertura", 'ilike', $search)
                    //     ->orWhere("fecha_cierre", 'ilike', $search)
                    //     ;
                    // })
                    ->when($this->oficina_id, function ($q) {
                        $q->whereHas('caja', function ($q) {
                            $q->whereOficinaId($this->oficina_id);
                        });
                    })
                    ->when($this->desde, function ($q) {
                        $q->whereDate('fecha_apertura', '>=', $this->desde);
                    })
                    ->when($this->hasta, function ($q) {
                        $q->whereDate('fecha_apertura', '<=', $this->hasta);
                    })
                    ->when($this->tipo_caja_id, function ($q) {
                        $q->whereHas('caja', function ($q) {
                            $q->whereTipoCajaId($this->tipo_caja_id);
                        });
                    })
                    ->when($this->cajero_id, function ($q) {
                        $q->whereHas('caja.cajeros', function ($q) {
                            $q->wherePersonalId($this->cajero_id);
                        });
                    })
                    ->paginate(10),
        ]);
    }
}
