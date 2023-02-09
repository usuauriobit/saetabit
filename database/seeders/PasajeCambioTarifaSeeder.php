<?php

namespace Database\Seeders;

use App\Models\CategoriaVuelo;
use App\Models\PasajeCambioTarifa;
use App\Services\TasaCambioService;
use Illuminate\Database\Seeder;

class PasajeCambioTarifaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categorias_vuelo = CategoriaVuelo::get();
        $tcs = new TasaCambioService();
        foreach ($categorias_vuelo as $categoria) {
            PasajeCambioTarifa::create([
                'categoria_vuelo_id'        => $categoria->id,
                'monto_cambio_fecha'        => 42,
                'monto_cambio_abierto'      => 42,
                'monto_cambio_titularidad'  => 42,
                'monto_cambio_ruta'         => 42,
            ]);
        }
    }
}
