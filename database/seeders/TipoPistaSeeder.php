<?php

namespace Database\Seeders;

use App\Models\TipoPista;
use Illuminate\Database\Seeder;

class TipoPistaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TipoPista::create(['descripcion' => 'Aeropuerto']);
        TipoPista::create(['descripcion' => 'Aeródromo']);
    }
}
