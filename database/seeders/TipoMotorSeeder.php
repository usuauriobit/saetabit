<?php

namespace Database\Seeders;

use App\Models\TipoMotor;
use Illuminate\Database\Seeder;

class TipoMotorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TipoMotor::create(['descripcion' => 'Monomotor']);
        TipoMotor::create(['descripcion' => 'Bimotor']);
        TipoMotor::create(['descripcion' => 'Turbo hélice']);
    }
}
