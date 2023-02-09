<?php

namespace App\Http\Livewire\Intranet\ProgramacionVuelo\Vuelo;

use App\Models\Avion;
use App\Models\Cliente;
use App\Models\Ruta;
use Illuminate\Support\Str;
use App\Models\TipoVuelo;
use App\Models\Tramo;
use App\Models\Ubicacion;
use App\Models\Ubigeo;
use App\Models\Vuelo;
use App\Models\VueloMassive;
use App\Models\VueloRuta;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Livewire\Component;

class CreateMassive extends Component
{
    public TipoVuelo $tipo_vuelo;
    public $semana = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'];
    public $semana_filtered = [];
    public $form = [];
    public Ruta|null $ruta;
    public $clientes;
    public $vuelos = [
        'ida' => [
            'origen' => [
                'ubicacion' => null,
                'fecha_despegue' => null,
            ],
            'escala' => [
                'ubicacion' => null,
                'fecha_aterrizaje' => null,
                'fecha_despegue' => null,
            ],
            'destino' => [
                'ubicacion' => null,
                'fecha_aterrizaje' => null,
            ],
        ],
        'vuelta' => [
            'origen' => [
                'ubicacion' => null,
                'fecha_despegue' => null,
            ],
            'escala' => [
                'ubicacion' => null,
                'fecha_aterrizaje' => null,
                'fecha_despegue' => null,
            ],
            'destino' => [
                'ubicacion' => null,
                'fecha_aterrizaje' => null,
            ],
        ],
    ];
    public $hasEscala = false;
    public $idaVuelta = false;
    public $tab = 'formulario';
    public $listeners = [
        // STEP 1
        'rutaSelected' => 'setRuta'
    ];
    public $vuelos_programados = [];
    public function validacion(){
        $rules = [
            'form.nro_asientos' => 'required',
            'form.fecha_inicio' => 'required|date',
            'form.fecha_final'  => 'required|date|after_or_equal:form.fecha_inicio',
            'semana_filtered'  => 'required',
            'vuelos.ida.origen.ubicacion.id'    => 'required',
            'vuelos.ida.origen.fecha_despegue'  => 'required',
        ];

        if($this->tipo_vuelo->descripcion == 'Subvencionado'){
            $rules['form.paquete']      = 'required';
            $rules['form.nro_contrato'] = 'required';
            $rules['form.cliente_id']   = 'required';
            $rules['form.monto_total']  = 'required';
        }

        if($this->ruta->tramo->escala_id){
            $rules['vuelos.ida.escala.ubicacion.id'] = 'required';
            $rules['vuelos.ida.escala.fecha_aterrizaje'] = 'required';
            $rules['vuelos.ida.escala.fecha_despegue'] = 'required';
        }
        $rules['vuelos.ida.destino.ubicacion.id'] = 'required';
        $rules['vuelos.ida.destino.fecha_aterrizaje'] = 'required';


        if($this->idaVuelta){
            $rules['vuelos.vuelta.origen.ubicacion.id'] = 'required';
            $rules['vuelos.vuelta.origen.fecha_despegue'] = 'required';

            if($this->ruta->tramo->escala_id){
                $rules['vuelos.vuelta.escala.ubicacion.id'] = 'required';
                $rules['vuelos.vuelta.escala.fecha_aterrizaje'] = 'required';
                $rules['vuelos.vuelta.escala.fecha_despegue'] = 'required';
            }
            $rules['vuelos.vuelta.destino.ubicacion.id'] = 'required';
            $rules['vuelos.vuelta.destino.fecha_aterrizaje'] = 'required';
        }
        return $this->validate($rules);
    }
    public function mount($tipo_vuelo_id){
        $this->tipo_vuelo = TipoVuelo::find($tipo_vuelo_id);
        if($this->tipo_vuelo->descripcion == 'Subvencionado'){
            $this->hasEscala = false;
        }
        $this->clientes = Cliente::get();
    }
    public function render()
    {
        $this->dispatchBrowserEvent('refreshJS');
        return view('livewire.intranet.programacion-vuelo.vuelo.create-massive');
    }
    public function setRuta(Ruta $ruta){
        $this->ruta = $ruta;
        $this->vuelos['ida']['origen']['ubicacion'] = $ruta->tramo->origen;
        $this->vuelos['ida']['escala']['ubicacion'] = $ruta->tramo->escala;
        $this->vuelos['ida']['destino']['ubicacion'] = $ruta->tramo->destino;
    }
    public function deleteRuta(){
        $this->ruta = null;
        $this->vuelos['ida']['origen']['ubicacion'] = null;
        $this->vuelos['ida']['escala']['ubicacion'] = null;
        $this->vuelos['ida']['destino']['ubicacion'] = null;
    }
    public function setRutaVuelta(){
        if($this->idaVuelta){
            $this->vuelos['vuelta']['origen']['ubicacion'] = $this->vuelos['ida']['destino']['ubicacion'];
            $this->vuelos['vuelta']['destino']['ubicacion'] = $this->vuelos['ida']['origen']['ubicacion'];
            $this->vuelos['vuelta']['escala']['ubicacion'] = $this->vuelos['ida']['escala']['ubicacion'];
        }else{
            $this->vuelos['vuelta']['origen']['ubicacion'] = null;
            $this->vuelos['vuelta']['destino']['ubicacion'] = null;
            $this->vuelos['vuelta']['escala']['ubicacion'] = null;
        }
    }
    public function getCantidadVuelosProperty(){
        return count($this->vuelos_programados);
    }
    public function generarVuelosProgramados(){
        $data =  $this->validacion();

        $period = CarbonPeriod::create($this->form['fecha_inicio'], '1 day', $this->form['fecha_final']);

        $vuelos_programados = collect();
        foreach ($period as $date) {
            if(in_array(ucfirst($date->dayName), $this->semana_filtered)){
                $codigo_vuelo = [
                    'ida' => (string) Str::uuid(),
                    'vuelta' => (string) Str::uuid(),
                ];
                $stop_number = [
                    'ida' => 0,
                    'vuelta' => 0,
                ];
                foreach ($data['vuelos'] as $ida_vuelta => $types) {
                    if(($ida_vuelta == 'vuelta' && $this->idaVuelta) || $ida_vuelta == 'ida'){
                        if($this->ruta->tramo->escala_id){
                            $vuelos_programados->push($this->generateVuelo($codigo_vuelo[$ida_vuelta], $date, $stop_number[$ida_vuelta]++, $types['origen'], $types['escala']));
                            $vuelos_programados->push($this->generateVuelo($codigo_vuelo[$ida_vuelta], $date, $stop_number[$ida_vuelta]++, $types['escala'], $types['destino']));
                        }else{
                            $vuelos_programados->push($this->generateVuelo($codigo_vuelo[$ida_vuelta], $date, $stop_number[$ida_vuelta]++, $types['origen'], $types['destino']));
                        }
                    }
                }
            }
        }
        $this->vuelos_programados = $vuelos_programados;
        $this->setTabResultados();
    }
    public function generateVuelo($codigo_vuelo, $date, $stop_number, $origen, $destino){
        return [
            'vuelo_codigo' => $codigo_vuelo,
            'origen_id'    => $origen['ubicacion']['id'],
            'destino_id'   => $destino['ubicacion']['id'],
            'fecha_hora_vuelo_programado'       => $date->format('Y-m-d ').$origen['fecha_despegue'],
            'fecha_hora_aterrizaje_programado'  =>  $date->format('Y-m-d ').$destino['fecha_aterrizaje'],
            'stop_number'  => $stop_number,
            'tipo_vuelo_id'  => $this->tipo_vuelo->id,
        ];
    }
    public function getVuelosProgramadosModelProperty(){
        $vuelos = collect();
        foreach ($this->vuelos_programados as $vuelo_programado) {
            $vuelos->push($this->parseVueloModel($vuelo_programado));
        }
        return $vuelos;
    }
    public function parseVueloModel($vuelo_programado){
        $vuelo = new Vuelo;
        $vuelo->fill([
            'vuelo_codigo' => $vuelo_programado['vuelo_codigo'],
            'origen_id'    => $vuelo_programado['origen_id'],
            'destino_id'   => $vuelo_programado['destino_id'],
            'fecha_hora_vuelo_programado'        => $vuelo_programado['fecha_hora_vuelo_programado'],
            'fecha_hora_aterrizaje_programado'   =>  $vuelo_programado['fecha_hora_aterrizaje_programado'],
            'stop_number'   => $vuelo_programado['stop_number'],
            'tipo_vuelo_id'   => $vuelo_programado['tipo_vuelo_id'],
        ]);
        return $vuelo;
    }
    public function save(){
        $data =  $this->validacion();
        $vuelo_massive = VueloMassive::create([
            'tipo_vuelo_id' => $this->tipo_vuelo->id,
            'ruta_id' => $this->ruta->id,
            'nro_asientos' => $data['form']['nro_asientos'] ?? null,
            'fecha_inicio' => $data['form']['fecha_inicio'],
            'fecha_final' => $data['form']['fecha_final'],
            'paquete' => $data['form']['paquete'] ?? null,
            'nro_contrato' => $data['form']['nro_contrato'] ?? null,
            'cliente_id' => $data['form']['cliente_id'] ?? null,
            'monto_total' => $data['form']['monto_total'] ?? null,
        ]);
        $vuelos = collect($this->vuelos_programados);
        foreach ($vuelos->groupBy('vuelo_codigo') as $vuelos) {
            $vuelo_ruta = VueloRuta::create(['tipo_vuelo_id' => $this->tipo_vuelo->id]);
            foreach ($vuelos as $vuelo) {
                $vuelo_m = $this->parseVueloModel($vuelo);
                $vuelo_m->vuelo_massive_id = $vuelo_massive->id;
                $vuelo_m->nro_asientos_ofertados = $vuelo_massive->nro_asientos;
                $vuelo_m->vuelo_ruta_id = $vuelo_ruta->id;
                $vuelo_m->save();
            }

            $vuelo_ruta->update([
                'origen_id'     => $vuelos[0]['origen_id'],
                'destino_id'    => $vuelos[count($vuelos)-1]['destino_id'],
                'fecha_hora_vuelo_programado' => $vuelos[0]['fecha_hora_vuelo_programado'],
                'fecha_hora_aterrizaje_programado' => $vuelos[count($vuelos)-1]['fecha_hora_aterrizaje_programado'],
            ]);
        }
        return redirect()->route('intranet.programacion-vuelo.vuelo.index');
    }

    public function setTabResultados(){
        $this->tab = 'resultados';
        $this->dispatchBrowserEvent('setCalendar', $this->vuelos_programados);
    }

    public function updatedVuelosIdaOrigenFechaDespegue(){
        $this->calcularFechaAterrizaje('ida');
    }
    public function updatedVuelosVueltaOrigenFechaDespegue(){
        $this->calcularFechaAterrizaje('vuelta');
    }
    private function calcularFechaAterrizaje($type){
        $hora_despegue = Carbon::createFromFormat('H:i', $this->vuelos[$type]['origen']['fecha_despegue']);
        $this->vuelos[$type]['destino']['fecha_aterrizaje'] = $hora_despegue->addMinutes($this->ruta->tramo->minutos_vuelo)->format('H:i:s');
    }
}
