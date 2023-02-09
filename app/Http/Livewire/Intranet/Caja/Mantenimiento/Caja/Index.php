<?php

namespace App\Http\Livewire\Intranet\Caja\Mantenimiento\Caja;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Caja;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $nro_pagination = 10;
    public $caja = null;
    public $form = [];
	public $oficinas, $movimientoss, $cajeros, $tipo_cajas, $comprobantess, $created_users, $updated_users, $deleted_users;
    protected function rules(){
        $rules = [
			'form.tipo_caja_id' => 'nullable',
			'form.oficina_id' => 'required',
			// 'form.cajero_id' => 'nullable',
			'form.descripcion' => 'required',
			'form.serie' => 'required',
        ];

        // if($this->caja){
        //     $rules = array_merge($rules,[
        //         'form.serie' => 'required|unique:cajas,serie,' . $this->caja->id,
        //     ]);
        // }
        return $rules;
    }

    public function mount(){
		$this->oficinas = \App\Models\Oficina::get();
		$this->movimientoss = \App\Models\CajaMovimiento::get();
		$this->cajeros = \App\Models\Personal::get();
		$this->tipo_cajas = \App\Models\TipoCaja::get();
		// $this->comprobantess = \App\Models\CajaComprobante::get();
		$this->created_users = \App\Models\User::get();
		$this->updated_users = \App\Models\User::get();
		$this->deleted_users = \App\Models\User::get();

    }

    public function render()
    {
		$search = '%'.$this->search .'%';
        return view('livewire.intranet.caja.mantenimiento.caja.index', [
            'items' => Caja::latest()
            ->when(strlen($this->search) > 2, function($q) use ($search){
				return $q
				->orWhereHas("tipo_caja", function($q) use ($search){
                    return $q->where("descripcion", "LIKE", $search);
                    // ->orWhere("", "LIKE", $search);
                })
				->orWhereHas("oficina", function($q) use ($search){
                    return $q->where("descripcion", "LIKE", $search);
                    // ->orWhere("", "LIKE", $search);
                })
				->orWhereHas("cajero", function($q) use ($search){
                    return $q->where("descripcion", "LIKE", $search);
                    // ->orWhere("", "LIKE", $search);
                })
				->orWhere("descripcion", "LIKE", $search);

            })
            ->paginate($this->nro_pagination),
        ]);
    }
    public function create(){
        $this->form = [];
        $this->caja = null;
    }
    public function show(Caja $caja){
        $this->caja = $caja;
    }
    public function edit(Caja $caja){
        $this->caja = $caja;
        $this->form = $caja->toArray();
    }
    public function destroy(Caja $caja){
        $caja->delete();
        $this->emit('notify', 'success', 'Se eliminó correctamente 😃.');
    }
    public function save(){
        $this->caja ? $this->update() : $this->store();
        $this->return();
    }
    public function store(){
        $form = $this->validate();
        $this->caja = Caja::create($form['form']);
    }
    public function update(){
        $form = $this->validate();
        $this->caja->update($form['form']);
    }
    public function return() {
        $this->form = [];
        $this->emit('closeModals');
        $this->emit('notify', 'success', 'Se registró correctamente 😃.');
    }
}
