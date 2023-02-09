<?php

namespace App\Http\Livewire\Intranet\Mantenimiento\Avion;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Avion;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $nro_pagination = 10;
    public Avion|null $avion = null;
    public $form = [];
	public $motors, $estados, $fabricantes;
    protected function rules(){
        $rules = [
			'form.tipo_motor_id' => 'required',
			'form.estado_avion_id' => 'required',
			'form.fabricante_id' => 'required',
			'form.nro_asientos' => 'required',
			'form.nro_pilotos' => 'required',
			'form.peso_max_pasajeros' => 'required',
			'form.peso_max_carga' => 'required',
			'form.fecha_fabricacion' => 'required',
			'form.descripcion' => 'required',
			'form.modelo' => 'required',
			'form.matricula' => 'required',

        ];

        if($this->avion){
            $rules = array_merge($rules,[
                // RULES EXTRA FOR EDITING PURPOSES
            ]);
        }
        return $rules;
    }

    public function mount(){
		$this->motors = \App\Models\TipoMotor::get();
		$this->estados = \App\Models\EstadoAvion::get();
		$this->fabricantes = \App\Models\Fabricante::get();
        // $this->personals = \App\Models\Personal::get();
    }

    public function render()
    {
		$search = '%'.$this->search .'%';
        return view('livewire.intranet.mantenimiento.avion.index', [
            'items' => Avion::latest()
            ->when(strlen($this->search) > 2, function($q) use ($search){
				return $q->searchFilter($search);

            })
            ->paginate($this->nro_pagination),
        ]);
    }
    public function create(){
        $this->form = [];
        $this->avion = null;
    }
    public function show(Avion $avion){
        $this->avion = $avion;
    }
    public function edit(Avion $avion){
        $this->avion = $avion;
        $this->form = $avion->toArray();
    }
    public function destroy(Avion $avion){
        $avion->delete();
        $this->emit('notify', 'success', 'Se eliminó correctamente 😃.');
    }
    public function save(){
        if($this->avion)
            $this->update();
        else
            $this->store();

        $this->return();
    }
    public function store(){
        $form = $this->validate();
        $this->avion = Avion::create($form['form']);
    }
    public function update(){
        $form = $this->validate();
        $this->avion->update($form['form']);
    }
    public function return() {
        $this->form = [];
        $this->emit('closeModals');
        $this->emit('notify', 'success', 'Se registró correctamente 😃.');
    }
}
