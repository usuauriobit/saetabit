<?php

namespace Database\Seeders;

use App\Models\TipoPasaje;
use App\Models\TipoPasajeCambio;
use Illuminate\Database\Seeder;

class TipoPasajeCambioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        TipoPasajeCambio::create(['descripcion' => 'Cambio de titular']);
        TipoPasajeCambio::create(['descripcion' => 'Cambio de fecha']);
        TipoPasajeCambio::create(['descripcion' => 'Cambio de ruta']);
    }
}
