<?php

namespace App\Http\Livewire\Intranet\ProgramacionVuelo\Vuelo;

use App\Models\Avion;
use App\Models\Cliente;
use App\Models\Persona;
use App\Models\Ruta;
use App\Models\TipoVuelo;
use App\Models\Ubicacion;
use App\Models\Venta;
use App\Models\Vuelo;
use App\Models\VueloCredito;
use App\Models\VueloRuta;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Livewire\Component;

class CreateSimple extends Component
{
    public TipoVuelo $tipo_vuelo;
    public $form = [];
    public $vuelos_generados = [];
    public $cliente = null;
    public $listeners = [
        'avionSelected' => 'setAvion',
        'ubicacionSelected' => 'setUbicacion',
        'clienteSelected' => 'setCliente',
        'rutaSelected'      => 'setRuta',
    ];
    public $isSaved = false;

    public $ruta = null;

    public function rulesToRegister() {
        return [
            'form.avion_id' => 'required',
            'form.origen_id' => 'required',
            'form.escala_id' => 'nullable',
            'form.destino_id' => 'required',
            'form.fecha_hora_vuelo_programado'
                => $this->is_no_regular
                    ? 'nullable'
                    : 'required|date_format:Y-m-d H:i',
            'form.fecha_hora_aterrizaje_programado'
                => $this->is_no_regular
                    ? 'nullable'
                    : 'required|date_format:Y-m-d H:i',
            'form.fecha' => $this->is_no_regular
                    ? 'required|date_format:Y-m-d'
                    : 'nullable',

        ];
    }

    public function rulesToSave(){
        return [
            'form.monto' => $this->has_cliente ? 'required' : 'nullable'
        ];
    }

    public function mount($tipo_vuelo_id = null, $vuelo = null){
        if(!is_null($tipo_vuelo_id)){
            $this->tipo_vuelo = TipoVuelo::find($tipo_vuelo_id);
        }
    }
    public function render() {
        $this->dispatchBrowserEvent('refreshJS');

        return view('livewire.intranet.programacion-vuelo.vuelo.create-simple');
    }
    public function save(){
        $this->validate($this->rulesToSave());

        if($this->has_cliente && !$this->cliente){
            $this->emit('notify', 'error', 'Registre un cliente');
            return;
        }

        $vuelo_ruta = VueloRuta::create(['tipo_vuelo_id' => $this->tipo_vuelo->id]);
        foreach ($this->vuelos_generados_model as $vuelo) {
            $vuelo->vuelo_ruta_id = $vuelo_ruta->id;
            $vuelo->save();
        }

        $vuelo_ruta->update([
            'origen_id'     => $this->vuelos_generados_model[0]['origen_id'],
            'destino_id'    => $this->vuelos_generados_model->last()['destino_id'],
            'fecha_hora_vuelo_programado' => $this->vuelos_generados_model[0]['fecha_hora_vuelo_programado'],
            'fecha_hora_aterrizaje_programado' => $this->vuelos_generados_model->last()['fecha_hora_aterrizaje_programado'],
        ]);

        if($this->has_cliente){
            VueloCredito::create([
                'vuelo_ruta_id' => $vuelo_ruta->id,
                'is_pagado' => false,
                'monto' => $this->form['monto'],
                'glosa'     => $this->form['glosa'] ?? null,
                'clientable_id' => $this->cliente->id,
                'clientable_type' => get_class($this->cliente)
            ]);
            // $venta = Venta::create([
            //     'clientable_id' => $this->cliente->id,
            //     'clientable_type' => get_class($this->cliente)
            // ]);
            // $venta->detalle()->create([
            //     'cantidad' => 1,
            //     'monto' => $this->form['monto'],
            //     'documentable_id' => $vuelo_ruta->id,
            //     'documentable_type' => get_class($vuelo_ruta),
            // ]);
        }
        return redirect()->route('intranet.programacion-vuelo.vuelo-ruta.show', $vuelo_ruta);
    }

    public function setAvion(Avion $avion){
        $this->form['avion_id'] = $avion->id;
    }
    public function removeAvion(){
        $this->form['avion_id'] = null;
    }

    public function setUbicacion($type, Ubicacion $ubicacion){
        if($type == 'origen'){
            $this->ubicacion_origen  = $ubicacion;
            $this->form['origen_id'] = $ubicacion->id;

        }elseif($type == 'destino'){
            $this->ubicacion_destino = $ubicacion;
            $this->form['destino_id'] = $ubicacion->id;

        }elseif($type == 'escala'){
            $this->form['escalas'][] = [
                'data' => $ubicacion,
            ];
        }
    }
    public function removeUbicacionOrigen(){
        $this->form['origen_id'] = null;
    }
    public function removeUbicacionDestino(){
        $this->form['destino_id'] = null;
    }
    public function removeVuelo($index){
        unset($this->vuelos_generados[$index]);
    }
    public function getAvionProperty(){
        return isset($this->form['avion_id']) ? Avion::find($this->form['avion_id']) : null;
    }
    public function getOrigenProperty(){
        return isset($this->form['origen_id']) ? Ubicacion::find($this->form['origen_id']) : null;
    }
    public function getEscalaProperty(){
        return isset($this->form['escala_id']) ? Ubicacion::find($this->form['escala_id']) : null;
    }
    public function getDestinoProperty(){
        return isset($this->form['destino_id']) ? Ubicacion::find($this->form['destino_id']) : null;
    }
    public function getIsRutaSelectedProperty(){
        return $this->origen && $this->destino;
    }
    public function getVuelosGeneradosModelProperty(){
        $vuelos = collect();
        foreach ($this->vuelos_generados as $index => $vuelo) {
            $data = new Vuelo();
            $data->fill(array_merge($vuelo, ['stop_number' => $index]));
            $vuelos->push($data);
        }
        return $vuelos;
    }

    public function addVuelo(){
        $data = $this->validate($this->rulesToRegister())['form'];

        if($this->is_no_regular){
            $fechas = [
                'fecha_hora_vuelo_programado'        => $data['fecha'],
                'fecha_hora_aterrizaje_programado'   => $data['fecha'],
            ];
        }else{
            $fechas = [
                'fecha_hora_vuelo_programado'        => $data['fecha_hora_vuelo_programado'],
                'fecha_hora_aterrizaje_programado'   => $data['fecha_hora_aterrizaje_programado'],
            ];
        }

        $data = array_merge($data,
            [
                'tipo_vuelo_id' => $this->tipo_vuelo->id,
                'nro_asientos_ofertados' => $this->avion->nro_asientos
            ], $fechas );

        if($this->is_no_regular){
            if($this->ruta->tramo->escala_id){
                $this->vuelos_generados[] = array_merge($data, [
                    'origen_id' => $this->form['origen_id'],
                    'destino_id' => $this->form['escala_id'],
                ]);
                $this->vuelos_generados[] = array_merge($data, [
                    'origen_id' => $this->form['escala_id'],
                    'destino_id' => $this->form['destino_id'],
                ]);
            }else{
                $this->vuelos_generados[] = $data;
            }
        }else{
            $this->vuelos_generados[] = $data;
        }


        if(!$this->is_no_regular){
            $this->form['origen_id'] = $this->form['destino_id'];
            $this->form['destino_id'] = null;
            $this->form['fecha_hora_vuelo_programado'] = null;
            $this->form['fecha_hora_aterrizaje_programado'] = null;
        }

    }

    public function setCliente($cliente_id, $type){
        if($type == 'persona_juridica'){
            $this->cliente = Cliente::find($cliente_id);
        }else{
            $this->cliente = Persona::find($cliente_id);
        }
    }
    public function removeCliente(){
        $this->cliente = null;
    }
    public function getMontoTotalProperty(){
        $monto_total = 0;
        foreach ($this->pasajes_model as $t => $pasajes)
            $monto_total += $pasajes->sum('importe');
        return $monto_total;
    }

    // PROPIEDAD: Indica si el tipo de vuelo requiere que se registre un cliente para generar los vuelos
    public function getHasClienteProperty(){
        return !$this->tipo_vuelo->is_compania
                && !$this->tipo_vuelo->is_no_regular;
    }
    public function getIsNoRegularProperty(){
        return $this->tipo_vuelo->is_no_regular;
    }
    public function setRuta(Ruta $ruta){
        $this->ruta = $ruta;
        $this->form['origen_id'] = $ruta->tramo->origen_id;
        $this->form['escala_id'] = $ruta->tramo->escala_id;
        $this->form['destino_id'] = $ruta->tramo->destino_id;
    }
    public function eliminarRuta(){
        $this->ruta = null;
        $this->form['origen_id'] = null;
        $this->form['escala_id'] = null;
        $this->form['destino_id'] = null;
    }
}
