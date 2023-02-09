<?php

namespace App\Http\Livewire\Intranet\Configuracion\Tramo;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Tramo;
use App\Models\Ubicacion;

class Index extends Component
{
    use WithPagination;

    public $ida_vuelta = true;
    public $search = '';
    public $nro_pagination = 10;
    public $tramo = null;
    public $form = [];
	public $origens, $destinos;

    public $origen;
    public $escala;
    public $destino;

    public $search_origen;
    public $search_destino;

    public function rules (){
        return [
            'form.minutos_vuelo' => 'required|numeric'
        ];
    }
    public $listeners = [
        'ubicacionSelected'     => 'setUbicacion',
    ];

    public function mount(){
		$this->origens = \App\Models\Ubicacion::get();
		$this->destinos = \App\Models\Ubicacion::get();
    }

    public function render()
    {
		$search = '%'.$this->search .'%';
		$search_origen = '%'.$this->search_origen .'%';
		$search_destino = '%'.$this->search_destino .'%';
        return view('livewire.intranet.configuracion.tramo.index', [
            'items' => Tramo::latest()
            // ->when(strlen($this->search) > 2, function($q) use ($search){
			// 	return $q
			// 	->whereHas("origen", function($q) use ($search){
            //         return $q->where('descripcion', 'LIKE', $search)
            //         ->orWhere('codigo_iata', 'LIKE', $search)
            //         ->orWhere('codigo_icao', 'LIKE', $search)
            //         ->orWhereHas('ubigeo', function($q) use ($search) {
            //             return $q->where('codigo', 'LIKE', $search)
            //                 ->orWhere('departamento', 'LIKE', $search)
            //                 ->orWhere('provincia', 'LIKE', $search)
            //                 ->orWhere('distrito', 'LIKE', $search);
            //         });
            //     })
			// 	->orWhereHas("destino", function($q) use ($search){
            //         return $q->where('descripcion', 'LIKE', $search)
            //         ->orWhere('codigo_iata', 'LIKE', $search)
            //         ->orWhere('codigo_icao', 'LIKE', $search)
            //         ->orWhereHas('ubigeo', function($q) use ($search) {
            //             return $q->where('codigo', 'LIKE', $search)
            //                 ->orWhere('departamento', 'LIKE', $search)
            //                 ->orWhere('provincia', 'LIKE', $search)
            //                 ->orWhere('distrito', 'LIKE', $search);
            //         });
            //     })
			// 	->orWhereHas("escala", function($q) use ($search){
            //         return $q->where('descripcion', 'LIKE', $search)
            //         ->orWhere('codigo_iata', 'LIKE', $search)
            //         ->orWhere('codigo_icao', 'LIKE', $search)
            //         ->orWhereHas('ubigeo', function($q) use ($search) {
            //             return $q->where('codigo', 'LIKE', $search)
            //                 ->orWhere('departamento', 'LIKE', $search)
            //                 ->orWhere('provincia', 'LIKE', $search)
            //                 ->orWhere('distrito', 'LIKE', $search);
            //         });
            //     });

            // })
            ->when($this->search_origen, function ($query) use ($search_origen) {
                $query->whereHas('origen.ubigeo', function ($query) use ($search_origen) {
                    $query->where('distrito', 'like', $search_origen);
                });
            })
            ->when($this->search_destino, function ($query) use ($search_destino) {
                $query->whereHas('destino.ubigeo', function ($query) use ($search_destino) {
                    $query->where('distrito', 'like', $search_destino);
                });
            })
            ->paginate($this->nro_pagination),
        ]);
    }
    public function create(){
        $this->form = [];
        $this->tramo = null;
    }
    public function show(Tramo $tramo){
        $this->tramo = $tramo;
    }
    public function edit(Tramo $tramo){
        $this->tramo = $tramo;
        $this->form = $tramo->toArray();
    }
    public function destroy(Tramo $tramo){
        $tramo->delete();
        $this->emit('notify', 'success', 'Se eliminó correctamente 😃.');
    }
    public function save(){

        if(!$this->origen && !$this->destino){
            $this->emit('notify', 'error', 'Registre correctamente todos los campos de ubiación');
            return;
        }

        $this->store();

        $this->return();
    }
    public function store(){
        $form = $this->validate()['form'];

        $data = [
            'origen_id' => $this->origen->id,
            'escala_id' => $this->escala->id ?? null,
            'destino_id' => $this->destino->id,
            'minutos_vuelo' => $form['minutos_vuelo']
        ];

        $exists = Tramo::where($data)->first();
        if($exists){
            $this->emit('notify', 'error', 'Ya existe un tramo registrado con estas ubicaciones');
            return;
        }

        Tramo::updateOrCreate($data, $data);

        $data_reverse = [
            'origen_id' => $this->destino->id,
            'escala_id' => $this->escala->id ?? null,
            'destino_id' => $this->origen->id,
            'minutos_vuelo' => $form['minutos_vuelo']
        ];
        if($this->ida_vuelta){
            Tramo::updateOrCreate($data_reverse, $data_reverse);
        }
    }
    public function update(){
        $form = $this->validate();
        $this->tramo->update($form['form']);
    }
    public function return() {
        $this->form = [];
        $this->emit('closeModals');
        $this->emit('notify', 'success', 'Se registró correctamente 😃.');
    }

    public function setUbicacion($type, Ubicacion $ubicacion){
        switch ($type) {
            case 'origen':
                $this->origen = $ubicacion;
                break;
            case 'escala':
                $this->escala = $ubicacion;
                break;
            case 'destino':
                $this->destino = $ubicacion;
                break;
            default:
                break;
        }
    }
    public function deleteUbicacion($type){
        switch ($type) {
            case 'origen':
                $this->origen = null;
                break;
            case 'escala':
                $this->escala = null;
                break;
            case 'destino':
                $this->destino = null;
                break;
            default:
                break;
        }
    }

    public function getCoordenadasProperty(){
        $coordenadas = [];
        $tramos = Tramo::get();
        foreach ($tramos as $tramo) {
            $data = [
                [
                    'lng' => $tramo->origen->geo_longitud,
                    'lat' => $tramo->origen->geo_latitud,
                ],
            ];
            if($tramo->escala){
                $data[] = [
                    'lng' => $tramo->escala->geo_longitud,
                    'lat' => $tramo->escala->geo_latitud,
                ];
            }
            $data[] = [
                'lng' => $tramo->destino->geo_longitud,
                'lat' => $tramo->destino->geo_latitud,
            ];

            $coordenadas[] = $data;
        }
        return $coordenadas;
    }
}
