<?php

namespace App\Http\Livewire\Intranet\Caja\Venta;

use App\Models\Cliente;
use App\Models\Persona;
use Livewire\WithPagination;
use Livewire\Component;
use App\Models\Venta;

class Index extends Component
{
    use WithPagination;

    public $n_venta = null;
    public $serie = null;
    public $correlativo = null;
    public $desde = null;
    public $hasta = null;
    public $search = '';
    public $nro_documento = '';
    public $nro_pagination = 10;

    public function mount()
    {
        $this->desde = date('Y-m-d');
        $this->hasta = date('Y-m-d');
    }

    public function render()
    {
        $search = '%'.$this->search .'%';
        $nro_documento = '%'.$this->nro_documento .'%';

        return view('livewire.intranet.caja.venta.index', [
            'items' => Venta::withTrashed()
                    ->latest()
                    ->has('caja_movimiento')
                    ->when(strlen($this->search) > 2, function($query) use ($search){
                        return $query->whereHasMorph(
                                'clientable',
                                [Persona::class, Cliente::class],
                                function ($query, $type) use ($search) {
                                    if($type === Cliente::class)
                                        $query->where('razon_social', 'like', $search);
                                    else
                                        $query->whereNombreLike($search);
                            });
                    })
                    ->when(strlen($this->nro_documento) > 2, function($query) use ($nro_documento){
                        return $query->whereHasMorph(
                                'clientable',
                                [Persona::class, Cliente::class],
                                function ($query, $type) use ($nro_documento) {
                                    if($type === Cliente::class)
                                        $query->where('ruc', 'like', $nro_documento);
                                    else
                                        $query->where('nro_doc', 'like', $nro_documento);
                            });
                    })
                    ->when($this->n_venta, function ($query) {
                        $query->where('id', 'like', "%$this->n_venta%");
                    })
                    ->when($this->serie, function ($query) {
                        $query->whereHas('comprobante', function ($query) {
                            $query->where('serie', 'like', "%$this->serie%");
                        });
                    })
                    ->when($this->correlativo, function ($query) {
                        $query->whereHas('comprobante', function ($query) {
                            $query->where('correlativo', 'like', "%$this->correlativo%");
                        });
                    })
                    ->when($this->desde, function ($query) {
                        $query->whereDate('created_at', '>=', $this->desde);
                    })
                    ->when($this->hasta, function ($query) {
                        $query->whereDate('created_at', '<=', $this->hasta);
                    })
                    ->paginate(10),
        ]);
    }
}
