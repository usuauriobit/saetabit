<?php

namespace App\Http\Livewire\Intranet\ProgramacionVuelo\Vuelo\Show;

use App\Models\GuiaDespacho;
use App\Models\GuiaDespachoStep;
use App\Models\Vuelo;
use Livewire\Component;

class SectionCargas extends Component
{
    public Vuelo $vuelo;
    public $tab = 'lista';
    public function setTab($tab){
        $this->tab = $tab;
    }
    public $listeners = [
        'guiaDespachoSetted' => 'setGuiaDespacho',
        'refreshSectionCarga' => '$refresh'
    ];

    public $form = [
        'codigo_guia_despacho'
    ];
    // public GuiaDespacho $guia_despacho;

    public function render()
    {
        return view('livewire.intranet.programacion-vuelo.vuelo.show.section-cargas');
    }
    public function setGuiaDespacho(GuiaDespacho $guia_despacho){

        $guia_despacho_step_exist = GuiaDespachoStep::
            where('guia_despacho_id', $guia_despacho->id)
            ->where('stepable_id', $this->vuelo->id)
            ->where('stepable_type', get_class($this->vuelo))
            ->first();

        if($guia_despacho_step_exist){
            $this->emit('notify', 'success', 'Esta guía de despacho ya tiene relación con este vuelo.');
            return;
        }

        GuiaDespachoStep::create([
            'guia_despacho_id' => $guia_despacho->id,
            'stepable_id' => $this->vuelo->id,
            'stepable_type' => get_class($this->vuelo),
            'fecha' => date('Y-m-d H:i:s')
        ]);
        $this->vuelo->refresh();
        $this->emit('refreshSectionCarga');
        $this->emit('refreshVuelo');
        $this->emit('notify', 'success', 'Se registró correctamente 😃.');
    }
    public function deleteGuiaDespachoStep(GuiaDespachoStep $guia_despacho_vuelo){
        $guia_despacho_vuelo->delete();
        $this->vuelo->refresh();
        $this->emit('refreshVuelo');
        $this->emit('refreshSectionCarga');
        $this->emit('notify', 'success', 'Se eliminó correctamente 😃.');
    }
    public function buscarGuiaDespacho(){
        $this->validate([
            'form.codigo_guia_despacho' => 'required|exists:guia_despachos,codigo'
        ]);
        $guia_despacho = GuiaDespacho::where('codigo', $this->form['codigo_guia_despacho'])->first();
        if(!$guia_despacho){
            $this->emit('notify', 'error', 'No se encontró la guía de despacho.');
            return;
        }
        if(!$guia_despacho->can_set_step){
            $this->emit('notify', 'error', $guia_despacho->reason_cant_set_step);
            return;
        }
        $this->setGuiaDespacho($guia_despacho);
    }
}
