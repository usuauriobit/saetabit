<?php

namespace App\Http\Livewire\Intranet\Comercial\Tarifa;

use App\Models\Ruta;
use App\Models\Tarifa;
use App\Models\TipoPasaje;
use App\Services\TasaCambioService;
use Livewire\Component;

class Create extends Component
{
    public $form = [];

    public $ruta;
    public $tipo_pasajes;
    protected function rules(){
        $rules = [
			// 'form.ruta_id' => 'required',
			'form.tipo_pasaje_id' => 'required',
			'form.precio' => 'required',
			// 'form.maximo_equipaje' => 'required',
			'form.descripcion' => 'required',

        ];
        return $rules;
    }

    public function mount(){
        // $this->rutas = Ruta::with([
        //     'tipo_vuelo',
        //     'tramo',
        //     'tramo.origen.ubigeo',
        //     'tramo.escala.ubigeo',
        //     'tramo.destino.ubigeo',
        // ])->get();
		$this->tipo_pasajes = TipoPasaje::get();

    }
    public function render()
    {
        return view('livewire.intranet.comercial.tarifa.create');
    }
    public function getPrecioSolesProperty(){
        return (new TasaCambioService())->getMontoSoles($this->form['precio'] ?? 0);
    }
    public function getIsDolarizadoProperty(){
        return optional($this->ruta)->is_dolarizado;
    }
    public function save(){
        $form = $this->validate();
        Tarifa::create(array_merge($form['form'], [
            'ruta_id' => $this->ruta->id,
            'is_dolarizado' => $this->ruta->is_dolarizado
        ]));
        if(!is_null($this->ruta->inverso)){
            Tarifa::create(array_merge($form['form'], [
                'ruta_id' => $this->ruta->inverso->id,
                'is_dolarizado' => $this->ruta->is_dolarizado
            ]));
        }
        $this->emit('notify', 'success', 'Se registró correctamente 😃.');
        $this->emit('closeModals');
        $this->emit('tarifaCreated');
    }
}
