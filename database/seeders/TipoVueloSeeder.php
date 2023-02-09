<?php

namespace Database\Seeders;

use App\Models\CategoriaVuelo;
use App\Models\TipoVuelo;
use Illuminate\Database\Seeder;

class TipoVueloSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // No regular
        // Comercial
        // Subencionado
        // Charter
            // Convenio
            // Paseo
            // Emergencia médica
        // Compañía
        // Encomienda
        TipoVuelo::create(['supports_massive_assign' => false,  'descripcion' => 'No regular',       'categoria_vuelo_id' => CategoriaVuelo::whereDescripcion('No regular')->first()->id]);
        TipoVuelo::create(['supports_massive_assign' => true,   'descripcion' => 'Comercial',        'categoria_vuelo_id' => CategoriaVuelo::whereDescripcion('Comercial')->first()->id]);
        TipoVuelo::create(['supports_massive_assign' => true,   'descripcion' => 'Subvencionado',    'categoria_vuelo_id' => CategoriaVuelo::whereDescripcion('Subvencionado')->first()->id]);
        TipoVuelo::create(['supports_massive_assign' => false,  'descripcion' => 'Convenio',         'categoria_vuelo_id' => CategoriaVuelo::whereDescripcion('Chárter')->first()->id]);
        TipoVuelo::create(['supports_massive_assign' => false,  'descripcion' => 'Chárter Comercial','categoria_vuelo_id' => CategoriaVuelo::whereDescripcion('Chárter')->first()->id]);
        TipoVuelo::create(['supports_massive_assign' => false,  'descripcion' => 'Emergencia médica','categoria_vuelo_id' => CategoriaVuelo::whereDescripcion('Chárter')->first()->id]);
        TipoVuelo::create(['supports_massive_assign' => false,  'descripcion' => 'Carga',            'categoria_vuelo_id' => CategoriaVuelo::whereDescripcion('Encomienda')->first()->id]);
        TipoVuelo::create(['supports_massive_assign' => false,  'descripcion' => 'Compañía',         'categoria_vuelo_id' => CategoriaVuelo::whereDescripcion('Compañía')->first()->id]);
    }
}
