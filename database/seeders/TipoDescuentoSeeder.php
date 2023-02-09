<?php

namespace Database\Seeders;

use App\Models\TipoDescuento;
use Illuminate\Database\Seeder;

class TipoDescuentoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TipoDescuento::create([
            'descripcion' => 'Vuelo'
        ]);
        TipoDescuento::create([
            'descripcion' => 'Pasaje'
        ]);
    }
}
