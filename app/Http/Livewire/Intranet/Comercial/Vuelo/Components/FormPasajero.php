<?php

namespace App\Http\Livewire\Intranet\Comercial\Vuelo\Components;

use App\Models\Pasaje;
use App\Models\Persona;
use App\Models\Tarifa;
use App\Models\TipoPasaje;
use App\Models\TipoVuelo;
use App\Models\Vuelo;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class FormPasajero extends Component
{
    // public $vuelos = [];
    public TipoVuelo|null $tipoVuelo = null;
    public $form = [];
    public $persona = null;
    public $listeners = [
        'pasajeroFounded' => 'setPasajero',
        'refreshFormPasajero' => '$refresh',
    ];
    public function validar(){
        $rules = [
            'form.persona_id' => 'required',
            'form.sexo' => 'required',
            'form.fecha_nacimiento' => 'required',
            'form.descripcion' => 'nullable',

            'form.peso_estimado' => 'nullable',
            'form.telefono' => 'nullable',
            'form.email' => 'nullable',

        ];
        if($this->tipoVuelo){
            if( in_array($this->tipoVuelo->desc_categoria, ['Comercial - Comercial', 'No regular - No regular', 'Subvencionado - Subvencionado']) ){
                $rules['form.peso_estimado'] = 'required';
                $rules['form.telefono'] = 'required';
                $rules['form.email'] = 'required';
            }
            if( in_array($this->tipoVuelo->desc_categoria, ['Chárter - Emergencia médica']) ){
                $rules['form.descripcion'] = 'required';
            }
        }
        return $this->validate($rules);
    }
    public function mount($tipoVuelo){
        $this->tipoVuelo = $tipoVuelo;
    }
    public function render()
    {
        return view('livewire.intranet.comercial.vuelo.components.form-pasajero');
    }

    public function setPasajero(Persona $persona){
        $this->persona = $persona;
        $this->form['persona_id']       = optional($this->persona)->id ?? null;
        $this->form['telefono']         = optional($persona->telefonos)[0]->nro_telefonico ?? null;
        $this->form['email']            = $persona->email;
        $this->form['sexo']             = $persona->sexo ? 1 : 0;
        $this->form['fecha_nacimiento'] = optional($persona->fecha_nacimiento)->format('Y-m-d');
        $this->form['peso_estimado']    = 0;
    }
    public function deletePasajero(){
        $this->persona = null;
        $this->form['persona_id'] = null;
        $this->form['descripcion'] = null;
        $this->form['peso_estimado'] = null;
        $this->form['telefono'] = null;
        $this->form['email'] = null;
    }
    public function getTipoPasajeProperty(){
        return TipoPasaje::where('edad_minima', '<=', $this->edad)
                ->where('edad_maxima', '>=', $this->edad)
                ->first();
    }
    public function getEdadProperty(){
        return Carbon::parse($this->form['fecha_nacimiento'])->age;
    }
    // public function getMontoProperty(){
    //     return Tarifa::whereTipoPasajeId($this->tipo_pasaje->id)
    //             ->whereHas('ruta', function ($q){

    //             })->first()->precio;
    // }

    public function setPasaje(){
        $data = $this->validar()['form'];

        $this->emit('pasajeSetted', array_merge(
            $data,
            [
                'temporal_id' => uniqid(),
                'nombre' => $this->persona->nombre_short,
                'tipo_documento' => optional(optional($this->persona)->tipo_documento)->toArray(),
                'nro_doc' => $this->persona->nro_doc,
                'tipo_pasaje' => $this->tipo_pasaje->toArray()
            ]));
        $this->deletePasajero();
    }
    // public function savePasajero(){
    //     $data = $this->validar()['form'];
    //     if(Auth::user()->is_personal){
    //         $pasaje = Pasaje::create([
    //             'tipo_pasaje_id'  => $this->tipo_pasaje->id,
    //             'pasajero_id'       => $data['persona_id'],
    //             'vuelo_id'          => $this->vuelo->id,
    //             'oficina_id'        => Auth::user()->personal->oficina_id,
    //             'importe'           => 0, // TODO: Hacer el cálculo de importe, analizar donde irá este registro
    //             'descuento'         => 0,
    //             // 'nro_asiento'       => null, // TODO: Se registrará el nro de asiento ?
    //             'descripcion'       => $data['descripcion'] ?? null,
    //             'peso_persona'      => $data['peso_estimado'] ?? null,
    //             'fecha'             => $data['fecha'] ?? null,
    //             'is_asistido'       => false,
    //             'is_compra_web'     => false,
    //         ]);
    //         $this->emit('pasajeSetted', $pasaje->id);
    //         $this->emit('closeModals');
    //         $this->emit('notify', 'success', 'El pasaje se ha registrado');
    //     }else{
    //         $this->emit('notify', 'error', 'Este usuario no tiene una oficina asignada.');
    //     }
    // }
}
