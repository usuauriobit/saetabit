<?php

namespace App\Http\Livewire\Intranet\Comercial\AdquisicionPasaje;

use App\Http\Livewire\Intranet\Comercial\AdquisicionPasaje\Traits\SaveTrait;
use App\Http\Livewire\Intranet\Comercial\AdquisicionPasaje\Traits\SectionPasajesTrait;
use App\Http\Livewire\Intranet\Comercial\AdquisicionPasaje\Traits\SectionResumenImporteTrait;
use App\Http\Livewire\Intranet\Comercial\AdquisicionPasaje\Traits\SectionSearchVueloTrait;
use App\Http\Livewire\Intranet\Comercial\AdquisicionPasaje\Traits\StepperTrait;
use App\Models\Descuento;
use App\Models\TipoVuelo;
use App\Models\Ubicacion;
use App\Models\User;
use App\Models\Vuelo;
use App\Models\VueloRuta;
use App\Services\DescuentoService;
use App\Services\VueloService;
use Illuminate\Support\Collection;
use Livewire\Component;

class Create extends Component {

    use StepperTrait;
    use SectionSearchVueloTrait;
    use SectionPasajesTrait;
    use SectionResumenImporteTrait;
    use SaveTrait;

    public TipoVuelo|null $tipo_vuelo = null;
    public $isLibre = false;
    // FROM FOR SEARCH
    public array $ida_vuelos_founded = [];
    public array $vuelta_vuelos_founded = [];
    public Ubicacion $origen;
    public Ubicacion $destino;
    public string $type_search = 'ida';

    // FROM VUELOS RESULTS
    public ?array $ida_vuelos_selected = null;
    public ?array $vuelta_vuelos_selected = null;

    public Collection $pasajeros_libre;

    public $descuentos_vuelo;
    // public $descuentos_pasaje;
    public ?Descuento $descuento_general = null;

    public $comprador = null;

    // IDA
    public Collection $ida_pasajes;

    // VUELTA
    public Collection $vuelta_pasajes;

    public $listeners = [
        'pasajeSetted'      => 'addPasaje',
        'clienteSelected'   => 'setCliente',
        'vueloSelected'     => 'setVueloSelected',
        'vuelosFounded'     => 'setVuelosFounded',
        'libreSetted'       => 'setAsLibre',
        'asignarDescuentoPasaje',
        'quitarDescuentoPasaje',
        'approvedFree'      => 'setApprovedFree',
    ];

    public $alreadySetType = null;
    public $alreadySetId = null;
    public $redirectRoute = null;

    public $aproved_by = null;

    protected $queryString = ['alreadySetType', 'alreadySetId', 'redirectRoute'];

    public function mount() {
        $this->pasajeros_libre = collect();
        $this->pasajes_comprados = collect();

        if($this->alreadySetType && $this->alreadySetId){
            $this->type_search = 'ida';
            switch ($this->alreadySetType) {
                case 'vuelo-ruta':
                    $vuelo_ruta = VueloRuta::find($this->alreadySetId);
                    $this->origen = $vuelo_ruta->origen;
                    $this->destino = $vuelo_ruta->destino;
                    $this->tipo_vuelo = $vuelo_ruta->tipo_vuelo;
                    $this->ida_vuelos_founded = [VueloService::generarVuelosAgrupados($vuelo_ruta->vuelo_inicial, $this->origen)];

                    $this->ida_vuelos_selected = $vuelo_ruta->vuelos->toArray();
                    $this->step = 2;

                    break;
                case 'vuelo':
                    $vuelo = Vuelo::find($this->alreadySetId);
                    $this->origen = $vuelo->origen;
                    $this->destino = $vuelo->destino;
                    $this->tipo_vuelo = $vuelo->tipo_vuelo;
                    $this->ida_vuelos_founded = [[$vuelo]];
                    $this->ida_vuelos_selected = [$vuelo->toArray()];
                    $this->step = 2;
                    break;
            }
        }

        $this->ida_pasajes = collect();
        $this->vuelta_pasajes = collect();

        // $this->descuentos_pasaje = Descuento::whereAvailable('Pasaje')->get();

        // $this->_generateRedirectRoute();

    }
    public function render(){
        return view('livewire.intranet.comercial.adquisicion-pasaje.create');
    }

    public function getAvailableTypesProperty(){
        // if($this->isLibre) return ['libre'];

        return $this->type_search == 'ida'
        ? ['ida']
        : ['ida', 'vuelta'];
    }

    public function setAsLibre($tipo_vuelo_id, Ubicacion $origen, Ubicacion $destino){
        $this->tipo_vuelo = TipoVuelo::find($tipo_vuelo_id);
        $this->origen = $origen;
        $this->destino = $destino;
        $this->isLibre = true;
        $this->step = 2;
    }
    // protected function _redirectToRoute() {
    //     if($this->alreadySetType && $this->alreadySetId){
    //             return redirect()
    //                 ->route('intranet.programacion-vuelo.'.$this->alreadySetType.'.show', $this->alreadySetId)
    //                 ->with('success', 'Se registró el pasaje correctamente');
    //     }
    // }

    public function getNoRucProperty(){
        return $this->tipo_vuelo->is_subvencionado;
    }

    public function getIsDolarizadoProperty(){
        if(count($this->all_pasajes_plane)>0)
            return $this->all_pasajes_plane[0]->is_dolarizado;
        return true;
    }

    public function setApprovedFree($eventId, $observacion, $userId){
        $this->aproved_by = User::find($userId);
    }
}
