<?php

namespace App\Http\Livewire\Intranet\Mantenimiento\TipoMotor;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\TipoMotor;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $tipo_motor = null;
    public $form = [];

    protected function rules(){
        $rules = [
			'form.descripcion' => 'required',

        ];

        if($this->tipo_motor){
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
        return view('livewire.intranet.mantenimiento.tipo_motor.index', [
            'items' => TipoMotor::latest()
            ->when(strlen($this->search) > 2, function($q) use ($search){
				return $q
				->orWhere("descripcion", "LIKE", $search);

            })
            ->paginate(10),
        ]);
    }
    public function create(){
        $this->form = [];
        $this->tipo_motor = null;
    }
    public function show(TipoMotor $tipo_motor){
        $this->tipo_motor = $tipo_motor;
    }
    public function edit(TipoMotor $tipo_motor){
        $this->tipo_motor = $tipo_motor;
        $this->form = $tipo_motor->toArray();
    }
    public function destroy(TipoMotor $tipo_motor){
        $tipo_motor->delete();
        $this->emit('notify', 'success', 'Se eliminó correctamente 😃.');
    }
    public function save(){
        if($this->tipo_motor)
            $this->update();
        else
            $this->store();

        $this->return();
    }
    public function store(){
        $form = $this->validate();
        $this->tipo_motor = TipoMotor::create($form['form']);
    }
    public function update(){
        $form = $this->validate();
        $this->tipo_motor->update($form['form']);
    }
    public function return() {
        $this->form = [];
        $this->emit('closeModals');
        $this->emit('notify', 'success', 'Se registró correctamente 😃.');
    }
}
