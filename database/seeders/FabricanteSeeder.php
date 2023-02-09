<?php

namespace Database\Seeders;

use App\Models\Fabricante;
use Illuminate\Database\Seeder;

class FabricanteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Fabricante::create(['descripcion' => 'Lockheed Martin']);
        Fabricante::create(['descripcion' => 'Airbus']);
        Fabricante::create(['descripcion' => 'Raytheon Technologies']);
        Fabricante::create(['descripcion' => 'Boeing']);
        Fabricante::create(['descripcion' => 'Safran']);
        Fabricante::create(['descripcion' => 'Textron']);
        Fabricante::create(['descripcion' => 'Dassaul Aviation']);
    }
}
