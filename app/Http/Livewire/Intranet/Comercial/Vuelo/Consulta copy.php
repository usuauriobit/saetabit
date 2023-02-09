<?php

namespace App\Http\Livewire\Intranet\Comercial\Vuelo;

use App\Http\Livewire\Intranet\Comercial\Vuelo\ConsultaTrait\EventListeners;
use App\Http\Livewire\Intranet\Comercial\Vuelo\ConsultaTrait\GeneralActions;
use App\Http\Livewire\Intranet\Comercial\Vuelo\ConsultaTrait\Properties;
use App\Http\Livewire\Intranet\Comercial\Vuelo\ConsultaTrait\Save;
use App\Http\Livewire\Intranet\Comercial\Vuelo\ConsultaTrait\UIActions;
use App\Models\Descuento;
use App\Models\TipoVuelo;
use Livewire\Component;
class Consulta extends Component
{
    use UIActions;
    use EventListeners;
    use GeneralActions;
    use Properties;
    use Save;

    public $listeners = [
        'ubicacionSelected' => 'setUbicacion',
        'rutaSelected' => 'setRuta',
        'pasajeSetted' => 'addPasaje',
        'clienteSelected' => 'setCliente',
    ];

    public $tipo_vuelos = [];
    public $tipo_descuento_pasajes = [];
    public $form = [
        'type' => 'solo_ida',
        'destino_id' => null,
        'origen_id' => null,
        'fecha_ida' => null,
        'fecha_vuelta' => null,
    ];
    public $vuelos_founded = [
        'ida' => [],
        'vuelta' => [],
    ];
    public $vuelos_selected = [
        'ida' => [],
    ];
    public $descuento_general;

    public $pasajes = [];
    public $pasajero_principal;
    public $cliente = null;

    public function mount(){
        $this->form['fecha_ida'] = date('Y-m-d');
        $this->tipo_vuelos = TipoVuelo::get();
        $this->form['tipo_vuelo_id']    = TipoVuelo::whereDescripcion('Comercial')->whereIsNotCharter()->first()->id;
        $this->tipo_descuento_pasajes   = Descuento::whereAvailable('Pasaje')->get();
    }
    public function render(){
        return view('livewire.intranet.comercial.vuelo.consulta');
    }
}
