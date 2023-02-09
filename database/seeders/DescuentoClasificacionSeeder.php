<?php

namespace Database\Seeders;

use App\Models\DescuentoClasificacion;
use Illuminate\Database\Seeder;

class DescuentoClasificacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DescuentoClasificacion::create(['descripcion' => 'Días de anticipación']);
        DescuentoClasificacion::create(['descripcion' => 'Regular']);
        DescuentoClasificacion::create(['descripcion' => 'Últimos cupos']);
        DescuentoClasificacion::create(['descripcion' => 'Rango de edades']);
        DescuentoClasificacion::create(['descripcion' => 'Interno']);
    }
}
