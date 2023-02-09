<?php
namespace App\Http\Livewire\Intranet\Comercial\AdquisicionPasaje\Traits;

use App\Models\PasajeLiberacionHistorial;
use App\Models\PasajeVuelo;
use App\Models\Venta;
use App\Services\PasajeService;
use App\Services\TasaCambioService;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

trait SaveTrait{

    public ?Collection $pasajes_comprados;

    public function save(){
        if(!Auth::user()->is_personal){
            $this->emit('notify','error','No eres personal, no puedes ejecutar esta acción');
            return;
        }
        if(!$this->comprador
            && $this->is_with_venta
        ){
            $this->emit('notify','error','Registre un comprador para poder emitir un recibo');
            return;
        }
        if($this->have_to_approve && !$this->aproved_by){
            $this->emit('notify','error','No puede realizar la acción sin haber sido aprobada');
            return;
        }

        if(!$this->isLibre){
            $asientos_disponibles_vuelos = $this->getNroAsientosDisponibles();

            if($asientos_disponibles_vuelos < 0){
                $this->emit('notify','error','Lo sentimos, el número de asientos disponibles se agotó mientras registraba el formulario 😣');
                return;
            }
        }

        $this->generatePasajes();
        $this->generateVenta();

        // RETORNAR AL PERFIL DEL COMPRADOR PARA MOSTRAR EL HISTORIAL DE COMPRAS
        // O RETORNAR AL VUELO DESDE EL QUE SE REDIRECCIONÓ
        return $this->return();
    }
    private function generatePasajes(){
        $tcs = new TasaCambioService();

        if($this->isLibre){
            foreach ($this->all_pasajes_plane as $pasaje) {
                $pasaje->tipo_vuelo_id  = $this->tipo_vuelo->id;
                $pasaje->origen_id      = $this->origen->id;
                $pasaje->destino_id     = $this->destino->id;
                $pasaje->is_abierto     = true;
                $pasaje->fecha_was_abierto = now();

                if($pasaje->is_dolarizado){
                    $pasaje->importe_final = $pasaje->importe_final_calc;
                    $pasaje->importe_final_soles = $tcs->getMontoSoles($pasaje->importe_final_calc);
                    $pasaje->tasa_cambio         = $tcs->tasa_cambio;
                }else{
                    $pasaje->importe_final_soles = $pasaje->importe_final_calc;
                    $pasaje->importe_final = null;
                    $pasaje->tasa_cambio = null;
                }

                $pasaje->save();

                $codigo_liberacion = uniqid();
                PasajeLiberacionHistorial::create([
                    'pasaje_id'        => $pasaje->id,
                    'codigo_historial' => $codigo_liberacion,
                ]);

                $this->pasajes_comprados->add($pasaje);
            }
        }else{
            $this->pasajes_comprados = collect();
            foreach ($this->all_pasajes as $type => $pasajes) {
                foreach ($pasajes as $pasaje) {
                    $pasaje->tipo_vuelo_id  = $this->tipo_vuelo->id;
                    $pasaje->origen_id      = $type == 'ida' ? $this->origen->id : $this->destino->id;
                    $pasaje->destino_id     = $type == 'ida' ? $this->destino->id : $this->origen->id;

                    if($pasaje->is_dolarizado){
                        $pasaje->importe_final = $pasaje->importe_final_calc;
                        $pasaje->importe_final_soles = $tcs->getMontoSoles($pasaje->importe_final_calc);
                        $pasaje->tasa_cambio         = $tcs->tasa_cambio;
                    }else{
                        $pasaje->importe_final_soles = $pasaje->importe_final_calc;
                        $pasaje->importe_final = null;
                        $pasaje->tasa_cambio = null;
                    }
                    $pasaje->save();

                    $this->pasajes_comprados->add($pasaje);

                    foreach ($this->{$type.'_vuelos_selected_model'} as $vuelo){
                        PasajeVuelo::create(['pasaje_id' => $pasaje->id, 'vuelo_id' => $vuelo['id']]);
                    }
                }
            }
            // foreach ($this->all_pasajes as $type => $pasajes) {
            //     foreach ($pasajes as $pasaje) {
            //         $pasaje->tipo_vuelo_id  = $this->tipo_vuelo->id;
            //         $pasaje->origen_id      = $type == 'ida' ? $this->origen->id : $this->destino->id;
            //         $pasaje->destino_id     = $type == 'ida' ? $this->destino->id : $this->origen->id;
            //         $pasaje->save();
            //         $this->pasajes_comprados->add($pasaje);
            //         foreach ($this->available_types as $type){
            //             foreach ($this->{$type.'_vuelos_selected_model'} as $vuelo){
            //                 PasajeVuelo::create(['pasaje_id' => $pasaje->id, 'vuelo_id' => $vuelo['id']]);
            //             }
            //         }

            //     }
            // }
        }

    }

    private function generateVenta(){
        if(!$this->is_with_venta) return;

        foreach ($this->pasajes_comprados as $pasaje) {
            // dd($pasaje['descuento']);
            if($pasaje['importe'] !== 0){
                $venta = Venta::create([
                    'clientable_id' => $this->comprador->id,
                    'clientable_type' => get_class($this->comprador)
                ]);

                $type_desc = $this->isLibre ? 'Pasaje abierto' : 'Pasaje';
                $ruta_des = $pasaje->vuelo_desc;

                $fecha_vuelo = optional(optional($pasaje->vuelo_origen)->fecha_hora_vuelo_programado)->format('d/m/Y') ?? 'Sin fecha definida';
                $venta->detalle()->create([
                    'cantidad'      => 1,
                    'descripcion'   => "{$type_desc}
                        - {$fecha_vuelo}
                        - {$ruta_des}
                        - {$pasaje->nombre_short}",
                    'monto'         => $pasaje->tarifa->precio_soles,
                    'tasa_cambio'   => $pasaje->tasa_cambio,
                    'monto_dolares' => $pasaje->tarifa->precio_dolares,
                    'documentable_id'   => $pasaje->id,
                    'documentable_type' => get_class($pasaje),
                ]);
                if(!is_null($pasaje->descuento_id)){
                    $venta->detalle()->create([
                        'cantidad'      => 1,
                        'descripcion'   => "Descuento - {$pasaje->descuento->descripcion}",
                        'monto'         => -1 * abs($pasaje->descuento->getMontoARestarSoles($pasaje->tarifa)),
                        'tasa_cambio'   => $pasaje->tasa_cambio,
                        'monto_dolares' => -1 * abs($pasaje->descuento->getMontoARestarDolares($pasaje->tarifa)),
                        'documentable_id'   => $pasaje->descuento->id,
                        'documentable_type' => get_class($pasaje->descuento),
                    ]);
                }
            }
        }

        if($this->has_descuento_general){
            // DESCUENTO DE IDA Y VUELTA
            $tcs = new TasaCambioService();

            $venta->detalle()->create([
                'cantidad'          => 1,
                'descripcion'       => "Descuento - {$this->descuento_general->descripcion}",
                'monto'             => $tcs->getMontoSoles((float) gmp_neg($this->monto_descuento_general)),
                'monto_dolares'     => gmp_neg($this->monto_descuento_general),
                'tasa_cambio'       => $tcs->tasa_cambio,
                'documentable_id'   => $this->descuento_general->id,
                'documentable_type' => get_class($this->descuento_general),
            ]);
        }
    }

    public function return (){
        if($this->alreadySetType && $this->alreadySetId){
                return redirect()
                    ->route('intranet.programacion-vuelo.'.$this->alreadySetType.'.show', $this->alreadySetId)
                    ->with('success', 'Se registró el pasaje correctamente');
        }else if(isset($this->redirectRoute) && !empty($this->redirectRoute)){
            return redirect($this->redirectRoute)
                ->with('success', 'Se registró la adquisición de pasaje correctamente');
        }

        if($this->comprador){
            return redirect()->route('intranet.comercial.cliente.show', [
                'cliente_id' => $this->comprador->id,
                'cliente_model' => str_replace("App\\Models\\", "", get_class($this->comprador)),
            ])->with('success', 'Se registró la adquisición de pasaje correctamente');
        }

        return redirect()->route('intranet.programacion-vuelo.vuelo-ruta.show', $this->ida_vuelos_selected_model[0]->vuelo_ruta_id)
            ->with('success', 'Se registró la adquisición de pasaje correctamente');
    }
}
?>
