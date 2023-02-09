<?php

namespace Database\Seeders;

use App\Models\DevolucionMotivo;
use Illuminate\Database\Seeder;

class DevoluicionMotivoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DevolucionMotivo::create(['descripcion' => 'Motivo 1']);
        DevolucionMotivo::create(['descripcion' => 'Motivo 2']);
        DevolucionMotivo::create(['descripcion' => 'Motivo 3']);
        DevolucionMotivo::create(['descripcion' => 'Motivo 4']);
        DevolucionMotivo::create(['descripcion' => 'Motivo 5']);
    }
}
