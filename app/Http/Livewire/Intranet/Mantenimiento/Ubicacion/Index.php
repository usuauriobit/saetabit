<?php

namespace App\Http\Livewire\Intranet\Mantenimiento\Ubicacion;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Ubicacion;
use App\Models\Ubigeo;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $ubicacion = null;
    public $form = [
        'ubigeo_id' => null
    ];
	public $ubigeos, $tipo_pistas;
    protected function rules(){
        $rules = [
			'form.ubigeo_id' => 'required',
			'form.tipo_pista_id' => 'required',
			'form.codigo_icao' => 'required',
			'form.codigo_iata' => 'nullable',
			'form.descripcion' => 'required',
			'form.geo_longitud' => 'nullable',
			'form.geo_latitud' => 'nullable',

        ];

        if($this->ubicacion){
            $rules = array_merge($rules,[
                // RULES EXTRA FOR EDITING PURPOSES
            ]);
        }
        return $rules;
    }

    public function booted(){
        if(!$this->ubicacion){
            $this->form['geo_longitud'] = config('geo.default_coordinates.lng');
            $this->form['geo_latitud'] = config('geo.default_coordinates.lat');
        }
    }
    public $listeners = [
        'ubigeoSetted' => 'setUbigeo',
    ];
    public function setUbigeo($id){
        $this->form['ubigeo_id'] = $id;
    }
    public function removeUbigeo(){
        $this->form['ubigeo_id'] = null;
    }
    public function getUbigeoProperty() {
        return Ubigeo::find($this->form['ubigeo_id']);
    }

    public function mount(){
		$this->ubigeos = \App\Models\Ubigeo::get();
		$this->tipo_pistas = \App\Models\TipoPista::get();
    }

    public function render()
    {
		$search = '%'.$this->search .'%';
        return view('livewire.intranet.mantenimiento.ubicacion.index', [
            'items' => Ubicacion::latest()
            ->when(strlen($this->search) > 2, function($q) use ($search){
				return $q
				->orWhereHas("ubigeo", function($q) use ($search){
                    return $q->where("descripcion", 'ilike', $search);
                    // ->orWhere("", 'ilike', $search);
                })
				->orWhereHas("tipo_pista", function($q) use ($search){
                    return $q->where("descripcion", 'ilike', $search);
                    // ->orWhere("", 'ilike', $search);
                })
				->orWhere("codigo_icao", 'ilike', $search)
				->orWhere("descripcion", 'ilike', $search)
				->orWhere("codigo_iata", 'ilike', $search);

            })
            ->paginate(10),
        ]);
    }
    public function create(){
        $this->form = [
            'ubigeo_id' => null
        ];
        $this->ubicacion = null;
    }
    public function show(Ubicacion $ubicacion){
        $this->ubicacion = $ubicacion;
        $this->emit('renderMap', [$ubicacion->geo_latitud, $ubicacion->geo_longitud]);
    }
    public function edit(Ubicacion $ubicacion){
        $this->ubicacion = $ubicacion;
        $this->form = $ubicacion->toArray();
    }
    public function destroy(Ubicacion $ubicacion){
        $ubicacion->delete();
        $this->emit('notify', 'success', 'Se eliminó correctamente 😃.');
    }
    public function save(){
        if($this->ubicacion)
            $this->update();
        else
            $this->store();

        $this->return();
    }
    public function store(){
        $form = $this->validate();
        $this->ubicacion = Ubicacion::create($form['form']);
    }
    public function update(){
        $form = $this->validate();
        $this->ubicacion->update($form['form']);
    }
    public function return() {
        $this->form = [
            'ubigeo_id' => null
        ];
        $this->emit('closeModals');
        $this->emit('notify', 'success', 'Se registró correctamente 😃.');
    }
}
