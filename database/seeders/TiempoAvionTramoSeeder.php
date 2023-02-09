<?php

namespace Database\Seeders;

use App\Models\Avion;
use App\Models\TiempoAvionTramo;
use App\Models\Tramo;
use Illuminate\Database\Seeder;

class TiempoAvionTramoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $aviones = Avion::get();
        $tramos_without_escala = Tramo::whereNull('escala_id')->get();

        foreach ($aviones as $avion) {
            foreach ($tramos_without_escala as $tramo) {
                $avion_id = $avion->id;
                $tiempo_vuelo = rand(10, 100);

                $tiempo_avion_tramo_exist = TiempoAvionTramo::
                    whereTramoId($tramo->id)
                    ->whereAvionId($avion_id)
                    ->first();
                if(!$tiempo_avion_tramo_exist){
                    // echo "AVION: " . $avion->id . " TRAMO: " . $tramo->id . "\n";
                    $avion->tiempo_avion_tramos()->create([
                        'tramo_id' => $tramo->id,
                        'tiempo_vuelo' => $tiempo_vuelo,
                    ]);
                }

                $tiempo_avion_tramo_inverso_exist = TiempoAvionTramo::
                    whereTramoId($tramo->inverso->id)
                    ->whereAvionId($avion_id)
                    ->first();
                if(!$tiempo_avion_tramo_inverso_exist){
                    // echo "AVION: " . $avion->id . " TRAMO: " . $tramo->id . "\n";
                    $avion->tiempo_avion_tramos()->create([
                        'tramo_id' => $tramo->inverso->id,
                        'tiempo_vuelo' => $tiempo_vuelo,
                    ]);
                }
            }
        }
    }
}
