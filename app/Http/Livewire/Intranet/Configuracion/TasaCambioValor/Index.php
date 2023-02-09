<?php

namespace App\Http\Livewire\Intranet\Configuracion\TasaCambioValor;

use App\Models\TasaCambioValor;
use Livewire\Component;

class Index extends Component{
    public $search = '';
    public function render(){
        return view('livewire.intranet.configuracion.tasa-cambio-valor.index', [
            'items' => TasaCambioValor::orderBy('fecha', 'desc')
                ->when(isset($this->search), function($q){
                    $q->where('valor_venta', 'LIKE', '%'.$this->search.'%')
                        ->orWhere('fecha', 'LIKE', '%'.$this->search.'%');
                })
                ->withTrashed()
                ->paginate(10)
        ]);
    }
    public function delete(TasaCambioValor $tasaCambioValor){
        $tasaCambioValor->delete();
    }
}
