<?php

namespace App\Http\Livewire\Intranet\TrackingCarga\GuiaDespacho\Components;

use App\Models\GuiaDespacho;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class CreateMovimiento extends Component
{
    public GuiaDespacho $guiaDespacho;

    public $tab = 'vuelo';

    public $oficina_selected;
    public function mount(){
        $this->oficina_selected_id = Auth::user()->oficinas[0]->id;
    }
    public function render(){
        return view('livewire.intranet.tracking-carga.guia-despacho.components.create-movimiento');
    }
    public function setTab($tab){
        $this->tab = $tab;
    }
    public function setOficina(){
        $this->emit('oficinaSelected', $this->oficina_selected_id);
    }
}
