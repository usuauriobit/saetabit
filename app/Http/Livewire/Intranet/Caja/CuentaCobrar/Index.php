<?php

namespace App\Http\Livewire\Intranet\Caja\CuentaCobrar;

use App\Models\CuentaCobrar;
use App\Models\GuiaDespacho;
use Livewire\WithPagination;
use App\Models\VueloCredito;
use App\Models\VueloMassive;
use App\Models\Cliente;
use App\Models\Oficina;
use App\Models\Persona;
use Livewire\Component;

class Index extends Component
{
    use WithPagination;

    // public $tab = 'vuelos_subvencionados';
    public $search = '';
    public $nro_doc = null;
    public $desde = null;
    public $hasta = null;
    public $oficina_id = null;
    public $oficinas = null;

    public function mount()
    {
        $this->oficinas = Oficina::get();
    }

    public function render()
    {
        $search = '%'.$this->search .'%';

        return view('livewire.intranet.caja.cuenta-cobrar.index', [
            'clientes' => Cliente::when(strlen($this->search) > 2, function($q) use ($search){
                                return $q->orWhere("ruc", 'ilike', $search)
                                        ->orWhere("razon_social", 'ilike', $search);
                            })->paginate(10),
            'personas' => Persona::when(strlen($this->search) > 2, function($q) use ($search){
                                return $q->orWhere("nro_doc", 'ilike', $search)
                                        ->orWhereRaw("CONCAT(nombres, ' ', apellido_paterno, ' ', apellido_materno) LIKE ?", [$search]);
                            })->paginate(10),
            'items' => CuentaCobrar::latest()
                            ->when($this->nro_doc, function($query){
                                $query->whereHasMorph(
                                    'clientable',
                                    [Cliente::class, Persona::class],
                                    function ($query, $type) {
                                        $column = $type === Persona::class ? 'nro_doc' : 'ruc';
                                        $query->where($column, 'ilike', "%{$this->nro_doc}%");
                                    }
                                );
                            })
                            ->when($this->oficina_id, function ($query) {
                                $query->whereOficinaId($this->oficina_id);
                            })
                            ->when($this->desde, function ($query) {
                                $query->whereDate('fecha_registro', '>=', $this->desde);
                            })
                            ->when($this->hasta, function ($query) {
                                $query->whereDate('fecha_registro', '<=', $this->hasta);
                            })
                            ->paginate(10)
        ]);
    }

    // public function setTab($tab)
    // {
    //     $this->tab = $tab;
    // }

    public function addCliente($class, $model_id)
    {
        $clientable = "App\Models\\{$class}"::find($model_id);
        $cuenta_cobrar = $clientable->cuentas_cobrar()->create([ 'fecha_registro' => date('Y-m-d') ]);

        redirect()->route('intranet.caja.cuenta-cobrar.show', $cuenta_cobrar)
                ->with('success', 'Cuenta por Cobrar generada correctamente, ahora puede ingresar el detalle de la cuenta.');
    }
}
