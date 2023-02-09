<?php
namespace App\Services;

use App\Models\Descuento;
use App\Models\Persona;
use App\Models\Tarifa;
use App\Models\TipoPasaje;
use App\Models\Ubicacion;
use App\Models\Ubigeo;
use App\Models\Vuelo;
use App\Services\Interface\IDescuentoService;
use App\Services\Trait\DescuentoService\DescuentosRestantesGetter;

class DescuentoService {
    use DescuentosRestantesGetter;

    public Vuelo        $vuelo_origen;
    public Tarifa       $tarifa;
    public Bool         $is_ida_vuelta;
    public TipoPasaje   $tipoPasaje;
    public Persona      $persona;
    public              $pasajesException;

    public function __construct(
        Vuelo       $vuelo_origen,
        Tarifa      $tarifa,
        Bool        $is_ida_vuelta,
        TipoPasaje  $tipoPasaje,
        Persona     $persona,
        $pasajesException = []

    ){
        $this->vuelo_origen = $vuelo_origen;
        $this->tarifa = $tarifa;
        $this->is_ida_vuelta = $is_ida_vuelta;
        $this->tipoPasaje = $tipoPasaje;
        $this->persona = $persona;
        $this->pasajesException = $pasajesException;
    }
}

?>
