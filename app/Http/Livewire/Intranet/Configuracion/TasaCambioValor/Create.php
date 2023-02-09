<?php

namespace App\Http\Livewire\Intranet\Configuracion\TasaCambioValor;

use App\Models\TasaCambioValor;
use Livewire\Component;

class Create extends Component {
    public TasaCambioValor|null $tasaCambioValor = null;
    public $form = [
        'fecha'         => null,
        'valor_venta'   => null,
    ];
    public $rules = [
        'form.fecha'         => 'required|date',
        'form.valor_venta'   => 'required|numeric',
    ];
    public function mount(){
        if($this->tasaCambioValor){
            $this->form = $this->tasaCambioValor->toArray();
        }else{
            $this->form['fecha'] = date('Y-m-d');
            $this->form['valor_venta'] = TasaCambioValor::latest('fecha')->first()->valor_venta ?? 0;
        }
    }
    public function render() {
        return view('livewire.intranet.configuracion.tasa-cambio-valor.create');
    }
    public function save(){
        if($this->tasaCambioValor)
            return $this->update();
        return $this->store();
    }
    public function update(){
        $data = $this->validate();
        $this->tasaCambioValor->update($data['form']);
        return redirect()->route('intranet.configuracion.tasa-cambio-valor.index')->with('success', 'Se registró correctamente');
    }
    public function store(){
        $data = $this->validate();
        TasaCambioValor::create($data['form']);
        // $this->emit('notify', 'success', 'Se registró con éxito');
        // $this->emit('closeModals');
        return redirect()->route('intranet.configuracion.tasa-cambio-valor.index')->with('success', 'Se registró correctamente');
    }
}
