<?php
namespace App\Http\Livewire\Intranet\Comercial\Vuelo\ConsultaTrait;

use App\Models\PasajeVuelo;
use App\Models\Venta;
use Illuminate\Support\Facades\Auth;

trait Save{

    public $pasajes_comprados = [];

    public function save(){
        if(!Auth::user()->is_personal){
            $this->emit('notify','error','No eres personal, no puedes ejecutar esta acción');
            return;
        }

        $this->generatePasajes();
        $this->generateVenta();

        // RETORNAR AL PERFIL DEL COMPRADOR PARA MOSTRAR EL HISTORIAL DE COMPRAS
        return redirect()->route('intranet.comercial.cliente.show', [
            'cliente_id' => $this->cliente->id,
            'cliente_model' => str_replace("App\\Models\\", "", get_class($this->cliente)),
        ]);
    }
    private function generatePasajes(){
        foreach ($this->pasajes_model as $type => $pasajes) {
            foreach ($pasajes as $pasaje) {
                $pasaje->save();
                $this->pasajes_comprados[] = $pasaje;

                foreach ($this->vuelos_selected_model as $type => $vuelos)
                    foreach ($vuelos as $vuelo)
                        PasajeVuelo::create(['pasaje_id' => $pasaje->id, 'vuelo_id' => $vuelo->id]);

            }
        }
    }

    private function generateVenta(){
        if(!$this->is_with_venta) return; // Se quitó, porque siempre debe generar la venta en caja, aunque el monto sea 0

        // dd('asdds');
        $venta = Venta::create([
            'clientable_id' => $this->cliente->id,
            'clientable_type' => get_class($this->cliente)
        ]);

        foreach ($this->pasajes_comprados as $pasaje) {
            $venta->detalle()->create([
                'cantidad'      => 1,
                'descripcion'   => "Pasaje - {$this->pasaje->fecha_vuelo} - {$this->pasaje->nombre_short} - {$this->pasaje->vuelo_desc}",
                'monto'         => $pasaje->importe_final,
                'documentable_id'   => $pasaje->id,
                'documentable_type' => get_class($pasaje),
            ]);
        }

        if($this->is_with_descuento){
            // DESCUENTO DE IDA Y VUELTA
            $venta->detalle()->create([
                'cantidad'          => 1,
                'descripcion'       => "Descuento - {$this->descuento_general->descripcion}",
                'monto'             => gmp_neg($this->monto_descuento_general),
                'documentable_id'   => $this->descuento_general->id,
                'documentable_type' => get_class($this->descuento_general),
            ]);
        }
    }
}
?>
