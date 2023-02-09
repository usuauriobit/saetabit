<?php

namespace Database\Seeders;

use App\Models\CategoriaDescuento;
use Illuminate\Database\Seeder;

class CategoriaDescuentoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){
        CategoriaDescuento::create(['descripcion' => 'Monto restado']);
        CategoriaDescuento::create(['descripcion' => 'Porcentaje']);
        CategoriaDescuento::create(['descripcion' => 'Monto fijo']);
    }
}
