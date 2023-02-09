<?php

namespace App\Http\Livewire\Intranet\ProgramacionVuelo\Vuelo\Show\SectionPasajeros;

use App\Models\Pasaje;
use App\Models\PasajeBulto;
use App\Models\TarifaBulto;
use App\Models\Venta;
use Livewire\Component;

class FormAddBulto extends Component
{
    public Pasaje $pasaje;

    public $tarifas_bulto;
    public $tipo_vuelo;
    public $tarifa_bulto_id;

    public $form = [
        'descripcion' => null,
        'cantidad' => null,
        'peso_total' => null,
        // 'peso_excedido' => null,
        // 'monto_exceso' => null,
    ];

    public $hasTarifas = true;

    public function rules(){
        return [
            'form.descripcion'  => 'required',
            'form.cantidad'     => 'required|numeric|min:1',
            'form.peso_total'   => !optional($this->tarifa_bulto)->is_monto_fijo
                                    ? 'required|numeric|min:1' : 'nullable',
            'form.importe'      => optional($this->tarifa_bulto)->is_monto_fijo
                                    ? 'required|numeric|min:1' : 'nullable',
        ];
    }

    public function mount(){
        // dd($this->pasaje->vuelos);
        $this->tipo_vuelo = $this->pasaje->vuelos[0]->tipo_vuelo;
        $this->hasTarifas = $this->tipo_vuelo->is_comercial;

        $this->tarifas_bulto = TarifaBulto::where('tipo_vuelo_id', $this->tipo_vuelo->id)->get();

        if($this->tarifas_bulto->count() > 0){
            $this->tarifa_bulto_id = $this->tarifas_bulto[0]->id;
        }

    }

    public function render(){
        return view('livewire.intranet.programacion-vuelo.vuelo.show.section-pasajeros.form-add-bulto');
    }

    public function getHasExcesoProperty(){
        if(!$this->hasTarifas) return false;

        if($this->tarifa_bulto->is_monto_fijo)
            return true;
        return (float) ($this->form['peso_total'] ?? 0) > $this->tarifa_bulto->peso_max;
    }

    public function getPesoExcedidoProperty(){
        if(!$this->hasTarifas) return 0;

        return $this->has_exceso
            ? (float) ($this->form['peso_total'] ?? 0) - (float) $this->tarifa_bulto->peso_max
            : 0;
    }
    public function getMontoExcesoProperty(){
        if(!$this->hasTarifas) return 0;

        return optional($this->tarifa_bulto)->monto_kg_excedido * $this->peso_excedido;
    }
    public function save(){
        $data = $this->validate()['form'];

        if($this->hasTarifas && !$this->tarifa_bulto){
            $this->emit('notify', 'error', 'No se ha seleccionado una tarifa de bulto');
        }

        $data = [
            'pasaje_id'     => $this->pasaje->id,
            'tarifa_bulto_id' => optional($this->tarifa_bulto)->id,
            'descripcion'   => $data['descripcion'],
            'cantidad'      => $data['cantidad'],
            'peso_total'    => $data['peso_total'],
            'peso_excedido' => $this->peso_excedido,
            'monto_exceso'  => optional($this->tarifa_bulto)->is_monto_fijo
                                ? $data['importe']
                                : $this->monto_exceso,
        ];
        $pasaje_bulto = PasajeBulto::create($data);

        // if($this->has_exceso){
        //     $venta = Venta::create([
        //         'clientable_id' => $this->pasaje->pasajero_id,
        //         'clientable_type' => get_class($this->pasaje->pasajero)
        //     ]);

        //     $descripcion = $this->tarifa_bulto->is_monto_fijo
        //         ? "Exceso de equipaje - {$this->peso_excedido} kg en pasaje {$this->pasaje->codigo}"
        //         : "Traslado de animal/mascota ({$pasaje_bulto->cantidad}) en pasaje {$this->pasaje->codigo}";

        //     $venta->detalle()->create([
        //         'cantidad'      => 1,
        //         'descripcion'   => $descripcion,
        //         'monto'         => $this->monto_exceso,
        //         'documentable_id'   => $pasaje_bulto->id,
        //         'documentable_type' => get_class($pasaje_bulto),
        //     ]);
        // }

        $this->emit('bultoAdded');
    }

    public function getTarifaBultoProperty(){
        return TarifaBulto::find($this->tarifa_bulto_id);
    }

}
