<?php

namespace App\Http\Livewire\Intranet\Configuracion\TarifaBulto;

use App\Models\TarifaBulto;
use Livewire\Component;

class Index extends Component
{
    public $tarifa_bultos;
    public $tab = null ;

    public $tarifa_bulto = null;
    public $form = [];

    public function mount(){
    }
    public function render(){
        $this->tarifa_bultos = TarifaBulto::with(['tipo_bulto', 'tipo_vuelo'])->get();
        $this->tab = $this->tab ?? optional($this->tarifa_bultos[0]->tipo_vuelo)->descripcion;
        return view('livewire.intranet.configuracion.tarifa-bulto.index');
    }
    public function setTab($tab){
        $this->tab = $tab;
    }

    public function edit(TarifaBulto $tarifa_bulto){
        $this->tarifa_bulto = $tarifa_bulto;
        $this->form = $tarifa_bulto->toArray();
    }
    public function create(){
        $this->form = [];
        $this->tarifa_bulto = null;
    }
    public function destroy(TarifaBulto $tarifa_bulto){
        $tarifa_bulto->delete();
        $this->emit('notify', 'success', 'Se eliminó correctamente 😃.');
    }
    public function save(){
        if($this->tarifa_bulto)
            $this->update();
        else
            $this->store();
        $this->return();
    }
    public function store(){
        // $form = $this->validate();
        $this->tarifa_bulto = TarifaBulto::create($this->form);
    }
    public function update(){
        // $form = $this->validate();
        $this->tarifa_bulto->update($this->form);
    }
    public function return() {
        $this->form = [];
        $this->emit('closeModals');
        $this->emit('notify', 'success', 'Se registró correctamente 😃.');
    }
}
