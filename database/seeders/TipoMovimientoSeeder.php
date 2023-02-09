<?php

namespace Database\Seeders;

use App\Models\TipoMovimiento;
use Illuminate\Database\Seeder;

class TipoMovimientoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TipoMovimiento::create([
            'descripcion' => 'Ingreso'
        ]);
        TipoMovimiento::create([
            'descripcion' => 'Salida'
        ]);
    }
}
