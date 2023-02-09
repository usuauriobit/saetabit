<?php

namespace Database\Seeders;

use App\Models\TipoNotaCredito;
use Illuminate\Database\Seeder;

class TipoNotaCreditoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TipoNotaCredito::create(['codigo' => 1, 'descripcion' => 'ANULACIÓN DE LA OPERACIÓN']);
        TipoNotaCredito::create(['codigo' => 2, 'descripcion' => 'ANULACIÓN POR ERROR EN EL RUC']);
        TipoNotaCredito::create(['codigo' => 3, 'descripcion' => 'CORRECCIÓN POR ERROR EN LA DESCRIPCIÓN']);
        TipoNotaCredito::create(['codigo' => 4, 'descripcion' => 'DESCUENTO GLOBAL']);
        TipoNotaCredito::create(['codigo' => 5, 'descripcion' => 'DESCUENTO POR ÍTEM']);
        TipoNotaCredito::create(['codigo' => 6, 'descripcion' => 'DEVOLUCIÓN TOTAL']);
        TipoNotaCredito::create(['codigo' => 7, 'descripcion' => ' DEVOLUCIÓN POR ÍTEM']);
        TipoNotaCredito::create(['codigo' => 8, 'descripcion' => 'BONIFICACIÓN']);
        TipoNotaCredito::create(['codigo' => 9, 'descripcion' => 'DISMINUCIÓN EN EL VALOR']);
        TipoNotaCredito::create(['codigo' => 10, 'descripcion' => 'OTROS CONCEPTOS']);
        TipoNotaCredito::create(['codigo' => 11, 'descripcion' => 'AJUSTES AFECTOS AL IVAP']);
        TipoNotaCredito::create(['codigo' => 12, 'descripcion' => 'AJUSTES DE OPERACIONES DE EXPORTACIÓN']);
        TipoNotaCredito::create(['codigo' => 13, 'descripcion' => 'AJUSTES - MONTOS Y/O FECHAS DE PAGO']);
    }
}
