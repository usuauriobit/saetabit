<?php

namespace App\Http\Livewire\Intranet\Configuracion\Personal;

use App\Models\Oficina;
use App\Models\Persona;
use App\Models\Personal;
use Livewire\Component;

class Create extends Component {
    public Personal|Null $personal = null;
    public $oficinas = [];
    public $form = [
        'oficina_id'         => null,
        'persona_id'         => null,
        'fecha_ingreso'         => null,
    ];
    public function rules(){
        $rules = [
            'form.oficina_id'         => 'required',
            'form.persona_id'         => 'required|unique:personals,persona_id',
            'form.fecha_ingreso'      => 'nullable',
        ];

        if($this->personal){
            $rules = array_merge($rules,[
                'form.persona_id'         => 'required|unique:personals,persona_id,'.$this->personal->id,
            ]);
        }

        return $rules;
    }
    public $listeners = [
        'personaFounded' => 'setPersona',
    ];
    public function mount(){
        $this->oficinas = Oficina::get();
        if($this->personal){
            $this->form = $this->personal->toArray();
        }
    }
    public function render() {
        return view('livewire.intranet.configuracion.personal.create');
    }
    public function setPersona(Persona $persona){
        $this->form['persona_id'] = $persona->id;
    }
    public function getPersonaProperty(){
        return Persona::find($this->form['persona_id']);
    }
    public function eliminarPersona(){
        $this->form['persona_id'] = null;
    }
    public function save(){
        if($this->personal)
            return $this->update();
        return $this->store();
    }
    public function update(){
        $data = $this->validate();
        $this->personal->update($data['form']);
        return redirect()->route('intranet.configuracion.personal.index')->with('success', 'Se registró correctamente');
    }
    public function store(){
        $data = $this->validate();
        Personal::create($data['form']);
        // $this->emit('notify', 'success', 'Se registró con éxito');
        // $this->emit('closeModals');
        return redirect()->route('intranet.configuracion.personal.index')->with('success', 'Se registró correctamente');
    }
}
