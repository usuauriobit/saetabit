<?php

namespace Database\Seeders;

use App\Models\Tripulacion;
use Illuminate\Database\Seeder;

class TripulacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Tripulacion::create([
            'persona_id' => 1,
            'tipo_tripulacion_id' => 1,
            'nro_licencia' => 12323,
            'fecha_vencimiento_licencia' => "2022-05-04"
        ]);
        Tripulacion::create([
            'persona_id' => 2,
            'tipo_tripulacion_id' => 1,
            'nro_licencia' => 12323,
            'fecha_vencimiento_licencia' => "2022-05-04"
        ]);
        Tripulacion::create([
            'persona_id' => 3,
            'tipo_tripulacion_id' => 1,
            'nro_licencia' => 12323,
            'fecha_vencimiento_licencia' => "2022-05-04"
        ]);
        Tripulacion::create([
            'persona_id' => 4,
            'tipo_tripulacion_id' => 2,
            'nro_licencia' => 12323,
            'fecha_vencimiento_licencia' => "2022-05-04"
        ]);
        Tripulacion::create([
            'persona_id' => 5,
            'tipo_tripulacion_id' => 2,
            'nro_licencia' => 12323,
            'fecha_vencimiento_licencia' => "2022-05-04"
        ]);
        Tripulacion::create([
            'persona_id' => 6,
            'tipo_tripulacion_id' => 2,
            'nro_licencia' => 12323,
            'fecha_vencimiento_licencia' => "2022-05-04"
        ]);
    }
}
