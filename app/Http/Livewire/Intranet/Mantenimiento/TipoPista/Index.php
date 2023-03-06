<?php

namespace App\Http\Livewire\Intranet\Mantenimiento\TipoPista;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\TipoPista;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $nro_pagination = 10;
    public $tipo_pista = null;
    public $form = [];

    protected function rules(){
        $rules = [
			'form.descripcion' => 'required',

        ];

        if($this->tipo_pista){
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
        return view('livewire.intranet.mantenimiento.tipo_pista.index', [
            'items' => TipoPista::latest()
            ->when(strlen($this->search) > 2, function($q) use ($search){
				return $q
				->orWhere("descripcion", 'ilike', $search);

            })
            ->paginate($this->nro_pagination),
        ]);
    }
    public function create(){
        $this->form = [];
        $this->tipo_pista = null;
    }
    public function show(TipoPista $tipo_pista){
        $this->tipo_pista = $tipo_pista;
    }
    public function edit(TipoPista $tipo_pista){
        $this->tipo_pista = $tipo_pista;
        $this->form = $tipo_pista->toArray();
    }
    public function destroy(TipoPista $tipo_pista){
        $tipo_pista->delete();
        $this->emit('notify', 'success', 'Se eliminó correctamente 😃.');
    }
    public function save(){
        if($this->tipo_pista)
            $this->update();
        else
            $this->store();

        $this->return();
    }
    public function store(){
        $form = $this->validate();
        $this->tipo_pista = TipoPista::create($form['form']);
    }
    public function update(){
        $form = $this->validate();
        $this->tipo_pista->update($form['form']);
    }
    public function return() {
        $this->form = [];
        $this->emit('closeModals');
        $this->emit('notify', 'success', 'Se registró correctamente 😃.');
    }
}
