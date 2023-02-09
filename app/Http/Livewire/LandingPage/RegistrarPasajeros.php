<?php

namespace App\Http\Livewire\LandingPage;

use App\Http\Livewire\LandingPage\RegistrarPasajerosTrait\ValidateStart;
use App\Models\OrdenPasaje;
use App\Models\Pasaje;
use App\Models\PasajeVuelo;
use App\Models\Persona;
use App\Models\Tarifa;
use App\Models\TipoDocumento;
use App\Models\TipoVuelo;
use App\Services\TarifaService;
use App\Services\TasaCambioService;
use App\Services\TipoDocumentoService;
use Illuminate\Http\Request;
use Livewire\Component;

class RegistrarPasajeros extends Component{
    use ValidateStart;
    public $qs_vuelos_ida;
    public $qs_vuelos_vuelta;
    public $qs_tarifas_ida;
    public $qs_tarifas_vuelta;
    protected $queryString = [
        'qs_vuelos_ida',
        'qs_vuelos_vuelta',
        'qs_tarifas_ida',
        'qs_tarifas_vuelta',
    ];

    public $startOk = false;
    public $errorMsg = '';

    public $tarifas_ida;
    public $tarifas_vuelta;
    public $vuelos_ida;
    public $vuelos_vuelta;

    public $pasajeros;
    public $tipo_documentos;

    public function mount(){
        $this->tipo_documentos = TipoDocumento::whereNotIn('descripcion', ['RUC', 'Sin documento'])->get();

        $this->_validarQs();
        $this->_validarVuelos();
        $this->_validarTarifas();
        $this->_validarAsientosDisponibles();
    }
    public function render(){
        return view('livewire.landing-page.registrar-pasajeros');
    }
    public function getIsIdaVueltaProperty (){
        return isset($this->qs_vuelos_vuelta);
    }

    public function save($tarifas_pasajeros){
        $isOk = $this->_validarAsientosDisponibles();
        if(!$isOk){
            return;
        }

        // Generar ORDEN web
        $orden = OrdenPasaje::create([
            'codigo' => uniqid('OP'),
            'fecha' => date('Y-m-d H:i:s'),
            'vuelo_origen_id' => $this->vuelos_ida[0]->id,
            'vuelo_destino_id' => $this->vuelos_ida->last()->id,
            'is_ida_vuelta' => $this->is_ida_vuelta,
        ]);
        // Registrar pasajeros de ida
        // Geenrar detalle de orden
        $this->_savePasajeroTarifaByType(type: 'ida', tarifas_pasajeros: $tarifas_pasajeros, orden: $orden);

        // Registrar pasajeros de vuelta
        // Generar detalle de orden
        if($this->is_ida_vuelta){
            $this->_savePasajeroTarifaByType(type: 'vuelta', tarifas_pasajeros: $tarifas_pasajeros, orden: $orden);
        }
        // Redireccionar a la vista de pago
        return redirect()->route('landing_page.registrar-pago', $orden->codigo);
    }
    public function getTypeProperty(){
        return $this->is_ida_vuelta ? ['ida', 'vuelta'] : ['ida'] ;
    }
    public function _savePasajeroTarifaByType(string $type, $tarifas_pasajeros, OrdenPasaje $orden){
        $tcs = new TasaCambioService();
        foreach ($this->{'tarifas_'.$type} as $tarifa) {
            $tarifa_db = Tarifa::find($tarifa['tarifa']['id']);
            foreach ($tarifas_pasajeros as $tarifa_pasajero) {
                if($tarifa_pasajero['id'] == $tarifa_db->id){
                    foreach ($tarifa_pasajero['pasajeros'] as $pasajero) {

                        $tipo_documento_id = TipoDocumentoService::getId($pasajero['tipo_documento_id']);

                        $persona_data = [
                            'nacionalidad_id'       => $pasajero['nacionalidad_id'] ?? null,
                            'tipo_documento_id'     => $tipo_documento_id,
                            'nro_doc'               => empty($pasajero['nro_documento'])
                                                        ? null
                                                        : $pasajero['nro_documento'],
                            'ubigeo_id'             => $pasajero['ubigeo_id'] ?? null,
                            'lugar_nacimiento_id'   => $pasajero['lugar_nacimiento_id'] ?? null,
                            'apellido_paterno'      => $pasajero['apellido_paterno'] ?? null,
                            'apellido_materno'      => $pasajero['apellido_materno'] ?? null,
                            'nombres'               => $pasajero['nombre'] ?? null,
                            'sexo'                  => $pasajero['sexo'] ?? null,
                            'fecha_nacimiento'      => empty($pasajero['fecha_nacimiento'])
                                                        ? null
                                                        : $pasajero['fecha_nacimiento'],
                        ];
                        // dd($persona_data);
                        $persona_db = null;
                        if(!empty($pasajero['nro_documento'])){
                            $persona_db = Persona::whereNroDoc($pasajero['nro_documento'])->first();
                        }

                        if(isset($persona_db)){
                            $persona_id = $persona_db->id;
                            $persona_db = $persona_db->update($persona_data);
                        }else{
                            $persona_db = Persona::create($persona_data);
                            $persona_id = $persona_db->id;
                        }

                        $pasaje_db = new Pasaje();
                        $pasaje_db->codigo          = uniqid('O');
                        $pasaje_db->orden_pasaje_id = $orden->id;
                        $pasaje_db->is_compra_web   = true;
                        $pasaje_db->pasajero_id     = $persona_id;
                        $pasaje_db->tipo_pasaje_id  = $tarifa_db->tipo_pasaje_id;
                        $pasaje_db->tarifa_id       = $tarifa_db->id;
                        $pasaje_db->descuento_id    = null;
                        $pasaje_db->fecha           = date('Y-m-d H:i:s');
                        $pasaje_db->importe         = $tarifa_db->precio;
                        $pasaje_db->tipo_vuelo_id   = TipoVuelo::whereIsComercial()->first()->id;
                        $pasaje_db->origen_id       = $this->{'vuelos_'.$type}[0]->origen_id;
                        $pasaje_db->destino_id      = $this->{'vuelos_'.$type}->last()->destino_id;
                        // dd($pasaje_db->importe_final_calc);

                        if($tarifa_db['is_dolarizado']){
                            $pasaje_db->importe_final       = $pasaje_db->importe_final_calc;
                            $pasaje_db->importe_final_soles = $tcs->getMontoSoles($pasaje_db->importe_final_calc);
                            $pasaje_db->tasa_cambio         = $tcs->tasa_cambio;
                        }else{
                            $pasaje_db->importe_final_soles = $pasaje_db->importe_final_calc;
                            $pasaje_db->importe_final       = null;
                            $pasaje_db->tasa_cambio         = null;
                        }
                        $pasaje_db->save();

                        foreach ($this->{'vuelos_'.$type} as $vuelo) {
                            PasajeVuelo::create(['pasaje_id' => $pasaje_db->id, 'vuelo_id' => $vuelo['id']]);
                        }
                    }
                }
            }
        }
    }
}
