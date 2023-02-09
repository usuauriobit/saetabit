<?php

namespace App\Http\Livewire\Intranet\Configuracion\Ruta;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Ruta;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $nro_pagination = 10;
    public $ruta = null;
    public $form = [];
	public $tipo_vuelos, $tramos;
    public $tipo_vuelo_id = null;
    public $search_origen = '';
    public $search_destino = '';
    public $colores = [
        'Subvencionado' => '#3498eb',
        'Comercial' => '#34ebc9',
    ];
    protected function rules(){
        $rules = [
			'form.tipo_vuelo_id' => 'required',
			'form.tramo_id' => 'required',

        ];

        if($this->ruta){
            $rules = array_merge($rules,[
                // RULES EXTRA FOR EDITING PURPOSES
            ]);
        }
        return $rules;
    }

    public function mount(){
		$this->tipo_vuelos = \App\Models\TipoVuelo::get();
		$this->tramos = \App\Models\Tramo::get();

    }

    public function render()
    {
		$search = '%'.$this->search .'%';
		$search_origen = '%'.$this->search_origen .'%';
		$search_destino = '%'.$this->search_destino .'%';

        return view('livewire.intranet.configuracion.ruta.index', [
            'items' => Ruta::latest()
            // ->when(strlen($this->search) > 2, function($q) use ($search){
			// 	return $q
			// 	->orWhereHas("tipo_vuelo", function($q) use ($search){
            //         return $q->where("descripcion", "LIKE", $search);
            //     })
			// 	->orWhereHas("tramo", function($q) use ($search){
            //         return $q
            //         ->whereHas("origen", function($q) use ($search){
            //             return $q->where('descripcion', 'LIKE', $search)
            //             ->orWhere('codigo_iata', 'LIKE', $search)
            //             ->orWhere('codigo_icao', 'LIKE', $search)
            //             ->orWhereHas('ubigeo', function($q) use ($search) {
            //                 return $q->where('codigo', 'LIKE', $search)
            //                     ->orWhere('departamento', 'LIKE', $search)
            //                     ->orWhere('provincia', 'LIKE', $search)
            //                     ->orWhere('distrito', 'LIKE', $search);
            //             });
            //             // ->orWhere("", "LIKE", $search);
            //         })
            //         ->orWhereHas("destino", function($q) use ($search){
            //             return $q->where('descripcion', 'LIKE', $search)
            //             ->orWhere('codigo_iata', 'LIKE', $search)
            //             ->orWhere('codigo_icao', 'LIKE', $search)
            //             ->orWhereHas('ubigeo', function($q) use ($search) {
            //                 return $q->where('codigo', 'LIKE', $search)
            //                     ->orWhere('departamento', 'LIKE', $search)
            //                     ->orWhere('provincia', 'LIKE', $search)
            //                     ->orWhere('distrito', 'LIKE', $search);
            //             });
            //         })
            //         ->orWhereHas("escala", function($q) use ($search){
            //             return $q->where('descripcion', 'LIKE', $search)
            //             ->orWhere('codigo_iata', 'LIKE', $search)
            //             ->orWhere('codigo_icao', 'LIKE', $search)
            //             ->orWhereHas('ubigeo', function($q) use ($search) {
            //                 return $q->where('codigo', 'LIKE', $search)
            //                     ->orWhere('departamento', 'LIKE', $search)
            //                     ->orWhere('provincia', 'LIKE', $search)
            //                     ->orWhere('distrito', 'LIKE', $search);
            //             });
            //         });
            //     });

            // })
            ->when($this->tipo_vuelo_id, function ($query) {
                $query->whereTipoVueloId($this->tipo_vuelo_id);
            })
            ->when($this->search_origen, function ($query) use ($search_origen) {
                $query->whereHas('tramo.origen.ubigeo', function ($query) use ($search_origen) {
                    $query->where('distrito', 'like', $search_origen);
                });
            })
            ->when($this->search_destino, function ($query) use ($search_destino) {
                $query->whereHas('tramo.destino.ubigeo', function ($query) use ($search_destino) {
                    $query->where('distrito', 'like', $search_destino);
                });
            })
            ->paginate($this->nro_pagination),
        ]);
    }
    public function create(){
        $this->form = [];
        $this->ruta = null;
    }
    public function show(Ruta $ruta){
        $this->ruta = $ruta;
    }
    public function edit(Ruta $ruta){
        $this->ruta = $ruta;
        $this->form = $ruta->toArray();
    }
    public function destroy(Ruta $ruta){
        $ruta->delete();
        $this->emit('notify', 'success', 'Se eliminó correctamente 😃.');
    }
    public function save(){
        if($this->ruta)
            $this->update();
        else
            $this->store();

        $this->return();
    }
    public function store(){
        $form = $this->validate();
        $this->ruta = Ruta::create($form['form']);
    }
    public function update(){
        $form = $this->validate();
        $this->ruta->update($form['form']);
    }
    public function return() {
        $this->form = [];
        $this->emit('closeModals');
        $this->emit('notify', 'success', 'Se registró correctamente 😃.');
    }
}
