<?php

namespace App\Http\Livewire\Intranet\Mantenimiento\Fabricante;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Fabricante;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $fabricante = null;
    public $form = [];

    protected function rules(){
        $rules = [
			'form.descripcion' => 'required',

        ];

        if($this->fabricante){
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
        return view('livewire.intranet.mantenimiento.fabricante.index', [
            'items' => Fabricante::latest()
            ->when(strlen($this->search) > 2, function($q) use ($search){
				return $q
				->orWhere("descripcion", 'ilike', $search);

            })
            ->paginate(10),
        ]);
    }
    public function create(){
        $this->form = [];
        $this->fabricante = null;
    }
    public function show(Fabricante $fabricante){
        $this->fabricante = $fabricante;
    }
    public function edit(Fabricante $fabricante){
        $this->fabricante = $fabricante;
        $this->form = $fabricante->toArray();
    }
    public function destroy(Fabricante $fabricante){
        $fabricante->delete();
        $this->emit('notify', 'success', 'Se eliminó correctamente 😃.');
    }
    public function save(){
        if($this->fabricante)
            $this->update();
        else
            $this->store();

        $this->return();
    }
    public function store(){
        $form = $this->validate();
        $this->fabricante = Fabricante::create($form['form']);
    }
    public function update(){
        $form = $this->validate();
        $this->fabricante->update($form['form']);
    }
    public function return() {
        $this->form = [];
        $this->emit('closeModals');
        $this->emit('notify', 'success', 'Se registró correctamente 😃.');
    }
}
