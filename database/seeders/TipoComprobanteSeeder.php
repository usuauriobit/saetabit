<?php

namespace Database\Seeders;

use App\Models\TipoComprobante;
use Illuminate\Database\Seeder;

class TipoComprobanteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TipoComprobante::create(['descripcion' => 'Factura', 'abreviatura' => 'F', 'codigo' => '1']);
        TipoComprobante::create(['descripcion' => 'Boleta', 'abreviatura' => 'B', 'codigo' => '2']);
        TipoComprobante::create(['descripcion' => 'Nota de Crédito', 'abreviatura' => 'NC', 'codigo' => '3']);
        TipoComprobante::create(['descripcion' => 'Nota de Débito', 'abreviatura' => 'NB', 'codigo' => '4']);
    }
}
