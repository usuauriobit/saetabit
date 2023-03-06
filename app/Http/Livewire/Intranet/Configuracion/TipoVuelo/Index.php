<?php

namespace App\Http\Livewire\Intranet\Configuracion\TipoVuelo;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\TipoVuelo;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $nro_pagination = 10;
    public $tipo_vuelo = null;
    public $form = [];
	public $categoria_vuelos;
    protected function rules(){
        $rules = [
			'form.categoria_vuelo_id' => 'required',
			'form.descripcion' => 'required',

        ];

        if($this->tipo_vuelo){
            $rules = array_merge($rules,[
                // RULES EXTRA FOR EDITING PURPOSES
            ]);
        }
        return $rules;
    }

    public function mount(){
		$this->categoria_vuelos = \App\Models\CategoriaVuelo::get();

    }

    public function render()
    {
		$search = '%'.$this->search .'%';
        return view('livewire.intranet.configuracion.tipo_vuelo.index', [
            'items' => TipoVuelo::latest()
            ->when(strlen($this->search) > 2, function($q) use ($search){
				return $q
				->orWhereHas("categoria_vuelo", function($q) use ($search){
                    return $q->where("descripcion", 'ilike', $search);
                    // ->orWhere("", 'ilike', $search);
                })
				->orWhere("descripcion", 'ilike', $search);

            })
            ->paginate($this->nro_pagination),
        ]);
    }
    public function create(){
        $this->form = [];
        $this->tipo_vuelo = null;
    }
    public function show(TipoVuelo $tipo_vuelo){
        $this->tipo_vuelo = $tipo_vuelo;
    }
    public function edit(TipoVuelo $tipo_vuelo){
        $this->tipo_vuelo = $tipo_vuelo;
        $this->form = $tipo_vuelo->toArray();
    }
    public function destroy(TipoVuelo $tipo_vuelo){
        $tipo_vuelo->delete();
        $this->emit('notify', 'success', 'Se eliminó correctamente 😃.');
    }
    public function save(){
        if($this->tipo_vuelo)
            $this->update();
        else
            $this->store();

        $this->return();
    }
    public function store(){
        $form = $this->validate();
        $this->tipo_vuelo = TipoVuelo::create($form['form']);
    }
    public function update(){
        $form = $this->validate();
        $this->tipo_vuelo->update($form['form']);
    }
    public function return() {
        $this->form = [];
        $this->emit('closeModals');
        $this->emit('notify', 'success', 'Se registró correctamente 😃.');
    }
}
