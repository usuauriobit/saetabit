<?php

namespace App\Http\Livewire\Intranet\Configuracion\Tripulacion;

use App\Models\Persona;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Tripulacion;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $nro_pagination = 10;
    public $tripulacion = null;
    public $persona_id = null;
    public $form = [
        'tipo_tripulacion_id' => null,
        'nro_licencia' => null,
        'fecha_vencimiento_licencia' => null,
    ];
	public $personas, $tipo_tripulacions;
    protected function rules(){
        $rules = [
			'form.tipo_tripulacion_id' => 'required',
			'form.nro_licencia' => 'nullable',
			'form.fecha_vencimiento_licencia' => 'nullable',

        ];

        if($this->tripulacion){
            $rules = array_merge($rules,[
                // RULES EXTRA FOR EDITING PURPOSES
            ]);
        }
        return $rules;
    }

    public $listeners = [
        'personaFounded' => 'setPersona'
    ];
    public function setPersona(Persona $persona){
        $this->persona_id = $persona->id;
    }
    public function deletePersona(){
        $this->persona_id = null;
    }
    public function getPersonaProperty(){
        return Persona::find($this->persona_id);
    }
    public function mount(){
		$this->personas = \App\Models\Persona::get();
		$this->tipo_tripulacions = \App\Models\TipoTripulacion::get();

        if($this->tripulacion)
            $this->persona_id = $this->tripulacion->persona_id;
    }

    public function render()
    {
		$search = '%'.$this->search .'%';
        return view('livewire.intranet.configuracion.tripulacion.index', [
            'items' => Tripulacion::latest()
            ->when(strlen($this->search) > 2, function($q) use ($search){
				return $q
				->orWhereHas("persona", function($q) use ($search){
                    return $q->where("descripcion", "LIKE", $search);
                    // ->orWhere("", "LIKE", $search);
                })
				->orWhereHas("tipo_tripulacion", function($q) use ($search){
                    return $q->where("descripcion", "LIKE", $search);
                    // ->orWhere("", "LIKE", $search);
                })
				->orWhere("nro_licencia", "LIKE", $search)
				->orWhere("fecha_vencimiento_licencia", "LIKE", $search);

            })
            ->paginate($this->nro_pagination),
        ]);
    }
    public function create(){
        $this->form = [];
        $this->persona_id = null;
        $this->tripulacion = null;
    }
    public function show(Tripulacion $tripulacion){
        $this->tripulacion = $tripulacion;
    }
    public function edit(Tripulacion $tripulacion){
        $this->tripulacion = $tripulacion;
        $this->persona_id = $tripulacion->persona_id;
        $this->form = $tripulacion->toArray();
    }
    public function destroy(Tripulacion $tripulacion){
        $tripulacion->delete();
        $this->emit('notify', 'success', 'Se eliminó correctamente 😃.');
    }
    public function save(){
        if(!$this->persona_id){
            $this->emit('notify','error','Seleccione una persona');
            return;
        }
        $this->tripulacion ? $this->update() : $this->store();
        $this->return();
    }
    public function store(){
        $form = $this->validate();
        $data = array_merge($form['form'], ['persona_id' => $this->persona_id]);
        $this->tripulacion = Tripulacion::create($data);
    }
    public function update(){
        $form = $this->validate();
        $data = array_merge($form['form'], ['persona_id' => $this->persona_id]);
        $this->tripulacion->update($data);
    }
    public function return() {
        $this->form = [];
        $this->emit('closeModals');
        $this->emit('notify', 'success', 'Se registró correctamente 😃.');
    }
}
