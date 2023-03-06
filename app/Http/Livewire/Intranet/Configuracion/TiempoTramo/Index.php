<?php

namespace App\Http\Livewire\Intranet\Configuracion\TiempoTramo;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\TiempoTramo;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $nro_pagination = 10;
    public $tiempo_tramo = null;
    public $form = [];
	public $tramos, $avions;
    protected function rules(){
        $rules = [
			'form.tramo_id' => 'required',
			'form.avion_id' => 'required',
			'form.tiempo_vuelo' => 'required',

        ];

        if($this->tiempo_tramo){
            $rules = array_merge($rules,[
                // RULES EXTRA FOR EDITING PURPOSES
            ]);
        }
        return $rules;
    }

    public function mount(){
		$this->tramos = \App\Models\Tramo::get();
		$this->avions = \App\Models\Avion::get();

    }

    public function render()
    {
		$search = '%'.$this->search .'%';
        return view('livewire.intranet.configuracion.tiempo_tramo.index', [
            'items' => TiempoTramo::latest()
            ->when(strlen($this->search) > 2, function($q) use ($search){
				return $q
				->orWhereHas("tramo", function($q) use ($search){
                    return $q->where("descripcion", 'ilike', $search);
                    // ->orWhere("", 'ilike', $search);
                })
				->orWhereHas("avion", function($q) use ($search){
                    return $q->where("descripcion", 'ilike', $search);
                    // ->orWhere("", 'ilike', $search);
                })
				->orWhere("tiempo_vuelo", 'ilike', $search);

            })
            ->paginate($this->nro_pagination),
        ]);
    }
    public function create(){
        $this->form = [];
        $this->tiempo_tramo = null;
    }
    public function show(TiempoTramo $tiempo_tramo){
        $this->tiempo_tramo = $tiempo_tramo;
    }
    public function edit(TiempoTramo $tiempo_tramo){
        $this->tiempo_tramo = $tiempo_tramo;
        $this->form = $tiempo_tramo->toArray();
    }
    public function destroy(TiempoTramo $tiempo_tramo){
        $tiempo_tramo->delete();
        $this->emit('notify', 'success', 'Se eliminó correctamente 😃.');
    }
    public function save(){
        if($this->tiempo_tramo)
            $this->update();
        else
            $this->store();

        $this->return();
    }
    public function store(){
        $form = $this->validate();
        $this->tiempo_tramo = TiempoTramo::create($form['form']);
    }
    public function update(){
        $form = $this->validate();
        $this->tiempo_tramo->update($form['form']);
    }
    public function return() {
        $this->form = [];
        $this->emit('closeModals');
        $this->emit('notify', 'success', 'Se registró correctamente 😃.');
    }
}
