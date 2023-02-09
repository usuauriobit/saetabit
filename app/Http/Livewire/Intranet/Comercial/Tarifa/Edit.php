<?php

namespace App\Http\Livewire\Intranet\Comercial\Tarifa;

use App\Models\Tarifa;
use App\Services\TasaCambioService;
use Livewire\Component;

class Edit extends Component
{
    public Tarifa $tarifa;
    public $precio = null;
    public $descripcion = null;
    public function mount(){
        $this->precio = $this->tarifa->precio;
        $this->descripcion = $this->tarifa->descripcion;
    }
    public function render()
    {
        return view('livewire.intranet.comercial.tarifa.edit');
    }
    public function getPrecioSolesProperty(){
        return (new TasaCambioService())->getMontoSoles($this->precio ?? 0);
    }

    public function updateTarifa(){
        $tarifa_db = $this->tarifa;
        $tarifa = Tarifa::create(array_merge($tarifa_db->toArray(), [
            'descripcion' => $this->descripcion,
            'precio' => $this->precio,
        ]));
        $tarifa_db->delete();

        $tarifa_db = $this->tarifa->inverso;
        if($tarifa_db){
            $tarifa = Tarifa::create(array_merge($tarifa_db->toArray(), [
                'descripcion' => $this->descripcion,
                'precio' => $this->precio,
            ]));
            $tarifa_db->delete();
        }

        $this->emit('tarifaUpdated', $tarifa);
        $this->emit('closeModals');
    }
}
