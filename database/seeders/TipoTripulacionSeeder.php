<?php

namespace Database\Seeders;

use App\Models\TipoTripulacion;
use Illuminate\Database\Seeder;

class TipoTripulacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TipoTripulacion::create(['descripcion' => 'Piloto']);
        TipoTripulacion::create(['descripcion' => 'Copiloto']);
    }
}
