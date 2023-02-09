<?php

namespace App\Http\Livewire\Intranet\Comercial\Cliente;

use Illuminate\Http\Client\Request;
use Livewire\Component;
use App\Models\Cliente;
use App\Models\GuiaDespacho;
use App\Models\Persona;
class Show extends Component
{
    public $cliente = null;
    public $tab = 'pagos';
    public function setTab($tab){
        $this->tab = $tab;
    }

    public function mount($cliente_id, $cliente_model){
        if($cliente_model == 'Persona')
            $this->cliente = $this->modelWithQuery(Persona::query())
                ->find($cliente_id);
        else
            $this->cliente = $this->modelWithQuery(Cliente::query())
                ->find($cliente_id);
    }
    public function render()
    {
        return view('livewire.intranet.comercial.cliente.show', [
            'guias' => $this->getGuias()
        ]);
    }

    private function modelWithQuery($model){
        return $model->with([
            // 'ventas', 'pasajes',
            // 'pasajes.vuelo_origen',
            // 'pasajes.vuelo_origen.origen',
            // 'pasajes.vuelo_destino',
            // 'pasajes.vuelo_destino.destino'
        ]);
    }

    public function getGuias()
    {
        if (get_class($this->cliente) == 'App\\Models\\Persona') {
            return GuiaDespacho::where('remitente_id', $this->cliente->id)
                    ->orWhere('consignatario_id', $this->cliente->id)
                    ->orderBy('fecha', 'desc')
                    ->paginate(10);
        }

        return GuiaDespacho::query();
    }
}
