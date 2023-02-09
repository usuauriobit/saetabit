<?php

namespace App\Http\Livewire\Intranet\Configuracion\CuentaBancariaReferencial;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\CuentaBancariaReferencial;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $nro_pagination = 10;
    public $cuenta_bancaria_referencial = null;
    public $form = [];

    protected function rules(){
        $rules = [
			'form.nro_cuenta' => 'required',
			'form.descripcion_cuenta' => 'required',
			'form.glosa' => 'required',
        ];

        if($this->cuenta_bancaria_referencial){
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
        return view('livewire.intranet.configuracion.cuenta-bancaria-referencial.index', [
            'items' => CuentaBancariaReferencial::latest()
            ->when(strlen($this->search) > 2, function($q) use ($search){
				return $q
				->orWhere("nro_cuenta", "LIKE", $search)
				->orWhere("descripcion_cuenta", "LIKE", $search)
				->orWhere("glosa", "LIKE", $search);

            })
            ->paginate($this->nro_pagination),
        ]);
    }
    public function create(){
        $this->form = [];
        $this->cuenta_bancaria_referencial = null;
    }
    public function show(CuentaBancariaReferencial $cuenta_bancaria_referencial){
        $this->cuenta_bancaria_referencial = $cuenta_bancaria_referencial;
    }
    public function edit(CuentaBancariaReferencial $cuenta_bancaria_referencial){
        $this->cuenta_bancaria_referencial = $cuenta_bancaria_referencial;
        $this->form = $cuenta_bancaria_referencial->toArray();
    }
    public function destroy(CuentaBancariaReferencial $cuenta_bancaria_referencial){
        $cuenta_bancaria_referencial->delete();
        $this->emit('notify', 'success', 'Se eliminó correctamente 😃.');
    }
    public function save(){
        $this->cuenta_bancaria_referencial ? $this->update() : $this->store();
        $this->return();
    }
    public function store(){
        $form = $this->validate();
        $this->cuenta_bancaria_referencial = CuentaBancariaReferencial::create($form['form']);
    }
    public function update(){
        $form = $this->validate();
        $this->cuenta_bancaria_referencial->update($form['form']);
    }
    public function return() {
        $this->form = [];
        $this->emit('closeModals');
        $this->emit('notify', 'success', 'Se registró correctamente 😃.');
    }
}
