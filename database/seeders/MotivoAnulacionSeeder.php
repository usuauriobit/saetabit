<?php

namespace Database\Seeders;

use App\Models\MotivoAnulacion;
use Illuminate\Database\Seeder;

class MotivoAnulacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        MotivoAnulacion::create(['descripcion' => 'Motivo 1']);
        MotivoAnulacion::create(['descripcion' => 'Motivo 2']);
        MotivoAnulacion::create(['descripcion' => 'Motivo 3']);
    }
}
