<?php

namespace Database\Seeders;

use App\Models\TipoCaja;
use Illuminate\Database\Seeder;

class TipoCajaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TipoCaja::create([ 'descripcion' => 'Oficina' ]);
        TipoCaja::create([ 'descripcion' => 'Call Center' ]);
    }
}
