<?php

namespace App\Http\Livewire\Intranet\Configuracion\Personal;

use App\Models\Persona;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Personal;
use App\Services\PersonaService;
use Illuminate\Support\Facades\DB;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $nro_pagination = 10;
    public $personal = null;
    public $form = [];
	public $oficinas, $personas;
    public $persona;

    protected $listeners = ['personaCreated' => 'setPersona'];

    protected function rules(){
        $rules = [
			'form.oficina_id' => 'required',
			'form.persona_id' => 'required',
			'form.fecha_ingreso' => 'nullable',

        ];

        if($this->personal){
            $rules = array_merge($rules,[
                // RULES EXTRA FOR EDITING PURPOSES
            ]);
        }
        return $rules;
    }

    public function mount(){
		$this->oficinas = \App\Models\Oficina::get();

        if($this->personal){
            $form['persona_search'] = $this->personal->persona->nro_doc;
            $this->persona = $this->personal->persona;
        }
    }

    public function render()
    {
		$search = '%'.$this->search .'%';
        return view('livewire.intranet.configuracion.personal.index', [
            'items' => Personal::latest()
            ->when(strlen($this->search) > 2, function($q) use ($search){
				return $q->indexFilter($search);
            })
            ->paginate($this->nro_pagination),
        ]);
    }
    public function create(){
        $this->form = [];
        $this->personal = null;
        $this->persona = null;
    }
    public function show(Personal $personal){
        $this->personal = $personal;
    }
    public function edit(Personal $personal){
        $this->personal = $personal;
        $this->persona = $personal->persona;
        $this->form = $personal->toArray();
        $this->form['persona_search'] = $personal->persona->nro_doc;
    }
    public function destroy(Personal $personal){
        $personal->delete();
        $this->emit('notify', 'success', 'Se eliminó correctamente 😃.');
    }
    public function save(){
        if($this->personal)
            $this->update();
        else
            $this->store();

        $this->return();
    }
    public function store(){
        $form = $this->validate();
        $this->personal = Personal::create($form['form']);
    }
    public function update(){
        $form = $this->validate();
        $this->personal->update($form['form']);
    }
    public function return() {
        $this->form = [];
        $this->emit('closeModals');
        $this->emit('notify', 'success', 'Se registró correctamente 😃.');
    }
    public function searchPersona(){
        $search = $this->form['persona_search'];
        $persona = PersonaService::searchPersona($search);

        $this->persona = Persona::where('nro_doc', $search)
        ->orWhere('id', $search)
        ->orWhere(DB::raw("CONCAT('nombres',' ','apellido_paterno',' ','apellido_materno')"), $search)
        ->first();

        $this->form['persona_id'] = optional($this->persona)->id ?? null;
    }
    public function setPersona(Persona $persona){
        $this->form['persona_id'] = $persona->id;
        $this->form['persona_search'] = $persona->nro_doc;
        $this->persona = $persona;
    }
}
