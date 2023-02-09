<?php

namespace Database\Seeders;

use App\Models\CategoriaVuelo;
use Illuminate\Database\Seeder;

class CategoriaVueloSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CategoriaVuelo::create(['descripcion' => 'No regular']);
        CategoriaVuelo::create(['descripcion' => 'Comercial']);
        CategoriaVuelo::create(['descripcion' => 'Subvencionado']);
        CategoriaVuelo::create(['descripcion' => 'Chárter']);
        CategoriaVuelo::create(['descripcion' => 'Compañía']);
        CategoriaVuelo::create(['descripcion' => 'Encomienda']);
    }
}
