<?php

namespace Database\Seeders;

use App\Models\EstadoAvion;
use Illuminate\Database\Seeder;

class EstadoAvionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        EstadoAvion::create(['descripcion' => 'En mantenimiento']);
        EstadoAvion::create(['descripcion' => 'Operativo']);
    }
}
