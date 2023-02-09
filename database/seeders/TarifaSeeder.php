<?php

namespace Database\Seeders;

use App\Models\Ruta;
use App\Models\Tarifa;
use App\Models\TipoPasaje;
use Illuminate\Database\Seeder;

class TarifaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $rutas = Ruta::get();
        foreach ($rutas as $ruta) {

            $precio = rand(100, 200);
            $tipo_pasajes = [
                [
                    'id' => 1,
                    'precio' => $precio,
                ],
                [
                    'id' => 2,
                    'precio' => $precio,
                ],
                [
                    'id' => 3,
                    'precio' => $precio/2,
                ]
            ];
            if($ruta->inverso && $ruta->inverso->tarifas->count() > 0){
                foreach ($tipo_pasajes as $index => $tipo_pasaje) {
                    $tipo_pasajes[$index]['precio'] = Tarifa::whereRutaId($ruta->inverso->id)
                        ->whereTipoPasajeId($tipo_pasaje['id'])
                        ->first()
                        ->precio;
                }
            }

            foreach ($tipo_pasajes as $tipo_pasaje) {
                $tipo_pasaje_db = TipoPasaje::find($tipo_pasaje['id']);
                Tarifa::create([
                    'ruta_id'           => $ruta->id,
                    'descripcion'       => $tipo_pasaje_db->abreviatura,
                    'tipo_pasaje_id'    => $tipo_pasaje['id'],
                    'precio'            => $tipo_pasaje['precio'],
                    'ocupa_asiento'     => $tipo_pasaje_db->ocupa_asiento,
                    'is_dolarizado'     => $ruta->is_comercial
                ]);
            }
        }
    }
}
