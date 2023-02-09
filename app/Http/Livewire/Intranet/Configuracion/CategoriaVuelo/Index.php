<?php

namespace App\Http\Livewire\Intranet\Configuracion\CategoriaVuelo;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\CategoriaVuelo;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $nro_pagination = 10;
    public $categoria_vuelo = null;
    public $form = [];

    protected function rules(){
        $rules = [
			'form.descripcion' => 'required',

        ];

        if($this->categoria_vuelo){
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
        return view('livewire.intranet.configuracion.categoria_vuelo.index', [
            'items' => CategoriaVuelo::latest()
            ->when(strlen($this->search) > 2, function($q) use ($search){
				return $q
				->orWhere("descripcion", "LIKE", $search);

            })
            ->paginate($this->nro_pagination),
        ]);
    }
    public function create(){
        $this->form = [];
        $this->categoria_vuelo = null;
    }
    public function show(CategoriaVuelo $categoria_vuelo){
        $this->categoria_vuelo = $categoria_vuelo;
    }
    public function edit(CategoriaVuelo $categoria_vuelo){
        $this->categoria_vuelo = $categoria_vuelo;
        $this->form = $categoria_vuelo->toArray();
    }
    public function destroy(CategoriaVuelo $categoria_vuelo){
        $categoria_vuelo->delete();
        $this->emit('notify', 'success', 'Se eliminó correctamente 😃.');
    }
    public function save(){
        if($this->categoria_vuelo)
            $this->update();
        else
            $this->store();

        $this->return();
    }
    public function store(){
        $form = $this->validate();
        $this->categoria_vuelo = CategoriaVuelo::create($form['form']);
    }
    public function update(){
        $form = $this->validate();
        $this->categoria_vuelo->update($form['form']);
    }
    public function return() {
        $this->form = [];
        $this->emit('closeModals');
        $this->emit('notify', 'success', 'Se registró correctamente 😃.');
    }
}
