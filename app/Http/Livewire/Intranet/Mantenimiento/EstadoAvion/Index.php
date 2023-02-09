<?php

namespace App\Http\Livewire\Intranet\Mantenimiento\EstadoAvion;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\EstadoAvion;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $estado_avion = null;
    public $form = [];

    protected function rules(){
        $rules = [
			'form.descripcion' => 'required',

        ];

        if($this->estado_avion){
            $rules = array_merge($rules,[
                // RULES EXTRA FOR EDITING PURPOSES
            ]);
        }
        return $rules;
    }

    public function mount(){

    }

    public function render()
    {
		$search = '%'.$this->search .'%';
        return view('livewire.intranet.mantenimiento.estado_avion.index', [
            'items' => EstadoAvion::latest()
            ->when(strlen($this->search) > 2, function($q) use ($search){
				return $q
				->orWhere("descripcion", "LIKE", $search);

            })
            ->paginate(10),
        ]);
    }
    public function create(){
        $this->form = [];
        $this->estado_avion = null;
    }
    public function show(EstadoAvion $estado_avion){
        $this->estado_avion = $estado_avion;
    }
    public function edit(EstadoAvion $estado_avion){
        $this->estado_avion = $estado_avion;
        $this->form = $estado_avion->toArray();
    }
    public function destroy(EstadoAvion $estado_avion){
        $estado_avion->delete();
        $this->emit('notify', 'success', 'Se eliminó correctamente 😃.');
    }
    public function save(){
        if($this->estado_avion)
            $this->update();
        else
            $this->store();

        $this->return();
    }
    public function store(){
        $form = $this->validate();
        $this->estado_avion = EstadoAvion::create($form['form']);
    }
    public function update(){
        $form = $this->validate();
        $this->estado_avion->update($form['form']);
    }
    public function return() {
        $this->form = [];
        $this->emit('closeModals');
        $this->emit('notify', 'success', 'Se registró correctamente 😃.');
    }
}
