<?php

namespace Database\Seeders;

use App\Models\Caja;
use App\Models\Oficina;
use App\Models\TipoCaja;
use Illuminate\Database\Seeder;

class CajaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $oficinas = Oficina::get();
        foreach ($oficinas as $oficina) {
            Caja::create([
                'oficina_id' => $oficina->id,
                'tipo_caja_id' => TipoCaja::whereDescripcion('Oficina')->first()->id,
                'descripcion' => 'Caja '.$oficina->descripcion
            ]);
            // Caja::create([
            //     'oficina_id' => $oficina->id,
            //     'descripcion' => 'Caja '.$oficina->descripcion.' - II'
            // ]);
        }
    }
}
