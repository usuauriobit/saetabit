<?php

namespace App\Http\Livewire\Intranet\Mantenimiento\TipoAvion;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\TipoAvion;

class Index extends Component
{
    use WithPagination;

    public $nro_pagination = 10;
    public $search = '';
    public $tipo_avion = null;
    public $form = [];

    protected function rules(){
        $rules = [
			'form.descripcion' => 'required',

        ];

        if($this->tipo_avion){
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
        return view('livewire.intranet.mantenimiento.tipo_avion.index', [
            'items' => TipoAvion::latest()
            ->when(strlen($this->search) > 2, function($q) use ($search){
				return $q
				->orWhere("descripcion", 'ilike', $search);

            })
            ->paginate($this->nro_pagination),
        ]);
    }
    public function create(){
        $this->form = [];
        $this->tipo_avion = null;
    }
    public function show(TipoAvion $tipo_avion){
        $this->tipo_avion = $tipo_avion;
    }
    public function edit(TipoAvion $tipo_avion){
        $this->tipo_avion = $tipo_avion;
        $this->form = $tipo_avion->toArray();
    }
    public function destroy(TipoAvion $tipo_avion){
        $tipo_avion->delete();
        $this->emit('notify', 'success', 'Se eliminó correctamente 😃.');
    }
    public function save(){
        if($this->tipo_avion)
            $this->update();
        else
            $this->store();

        $this->return();
    }
    public function store(){
        $form = $this->validate();
        $this->tipo_avion = TipoAvion::create($form['form']);
    }
    public function update(){
        $form = $this->validate();
        $this->tipo_avion->update($form['form']);
    }
    public function return() {
        $this->form = [];
        $this->emit('closeModals');
        $this->emit('notify', 'success', 'Se registró correctamente 😃.');
    }
}
