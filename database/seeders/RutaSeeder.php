<?php

namespace Database\Seeders;

use App\Models\Ruta;
use App\Models\TipoVuelo;
use App\Models\Tramo;
use Illuminate\Database\Seeder;

class RutaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tramos = Tramo::get();
        foreach ($tramos as $tramo) {
            Ruta::create([
                'tipo_vuelo_id' => TipoVuelo::whereDescripcion('Subvencionado')->first()->id,
                'tramo_id' => $tramo->id,
                'minutos_vuelo' => 120
            ]);
            Ruta::create([
                'tipo_vuelo_id' => TipoVuelo::whereDescripcion('Comercial')->first()->id,
                'tramo_id' => $tramo->id,
                'minutos_vuelo' => 120
            ]);
            Ruta::create([
                'tipo_vuelo_id' => TipoVuelo::whereDescripcion('No regular')->first()->id,
                'tramo_id' => $tramo->id,
                'minutos_vuelo' => 120
            ]);
        }
    }
}
