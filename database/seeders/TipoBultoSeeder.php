<?php

namespace Database\Seeders;

use App\Models\TipoBulto;
use Illuminate\Database\Seeder;

class TipoBultoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TipoBulto::create([ 'descripcion' => 'Equipaje - Peso']);
        TipoBulto::create([ 'descripcion' => 'Equipaje - Exceso de tamaño']);
        // SI SE EDITA REVISAR EN OTROS LUGARES DONDE SE COMPRA LA DESCRIPCION
        TipoBulto::create([ 'descripcion' => 'Animal/mascota']);
    }
}
