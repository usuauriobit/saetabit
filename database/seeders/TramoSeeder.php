<?php

namespace Database\Seeders;

use App\Models\Tramo;
use App\Models\Ubicacion;
use App\Models\Ubigeo;
use Illuminate\Database\Seeder;

class TramoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $tramos = [
            [
                'node1' => 'Jaén',
                'escale' => 'Rioja',
                'node2' => 'Tarapoto',
            ],
            [
                'node1' => 'Jaén',
                'escale' => '',
                'node2' => 'Rioja',
            ],
            [
                'node1' => 'Rioja',
                'escale' => '',
                'node2' => 'Tarapoto',
            ],
            [
                'node1' => 'Tarapoto',
                'escale' => '',
                'node2' => 'Pucallpa',
            ],
            [
                'node1' => 'Tarapoto',
                'escale' => 'Yurimaguas',
                'node2' => 'Iquitos',
            ],
            [
                'node1' => 'Tarapoto',
                'escale' => '',
                'node2' => 'Yurimaguas',
            ],
            [
                'node1' => 'Yurimaguas',
                'escale' => '',
                'node2' => 'Iquitos',
            ],
            [
                'node1' => 'Tarapoto',
                'escale' => '',
                'node2' => 'Iquitos',
            ],
        ];

        foreach ($tramos as $tramo) {
            echo $tramo['node2']."<br>";
            Tramo::create([
                'origen_id'  => Ubicacion::whereHas('ubigeo', fn($q) => $q->whereDistrito($tramo['node1']))->first()->id ?? null,
                'escala_id'  => Ubicacion::whereHas('ubigeo', fn($q) => $q->whereDistrito($tramo['escale']))->first()->id ?? null,
                'destino_id' => Ubicacion::whereHas('ubigeo', fn($q) => $q->whereDistrito($tramo['node2']))->first()->id ?? null,
                'minutos_vuelo' => 120
            ]);
            Tramo::create([
                'origen_id'  => Ubicacion::whereHas('ubigeo', fn($q) => $q->whereDistrito($tramo['node2']))->first()->id ?? null,
                'escala_id'  => Ubicacion::whereHas('ubigeo', fn($q) => $q->whereDistrito($tramo['escale']))->first()->id ?? null,
                'destino_id' => Ubicacion::whereHas('ubigeo', fn($q) => $q->whereDistrito($tramo['node1']))->first()->id ?? null,
                'minutos_vuelo' => 120
            ]);
        }
    }
}
