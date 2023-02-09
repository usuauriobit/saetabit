<?php

namespace Database\Seeders;

use App\Models\TipoPasaje;
use Illuminate\Database\Seeder;

class TipoPasajeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TipoPasaje::create([
            'descripcion' => 'Adulto',
            'abreviatura' => 'ADT',
            'edad_maxima' => 200,
            'edad_minima' => 18,
            'ocupa_asiento' => true
        ]);
        TipoPasaje::create([
            'descripcion' => 'Niño',
            'abreviatura' => 'CHD',
            'edad_maxima' => 17,
            'edad_minima' => 4,
            'ocupa_asiento' => true
        ]);
        TipoPasaje::create([
            'descripcion' => 'Infante',
            'abreviatura' => 'INF',
            'edad_maxima' => 3,
            'edad_minima' => 0,
            'ocupa_asiento' => false
        ]);
    }
}
