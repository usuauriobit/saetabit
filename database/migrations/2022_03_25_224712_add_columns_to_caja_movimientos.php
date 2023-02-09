<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToCajaMovimientos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('caja_movimientos', function (Blueprint $table) {
            $table->foreignId('tipo_pago_id')->constrained();
            $table->date('fecha_pago');
            $table->boolean('is_pagado');
            $table->foreignId('cuenta_bancaria_id')->nullable()->constrained('oficina_cuenta_bancarias');
            $table->string('nro_operacion')->nullable();
            $table->foreignId('tarjeta_id')->nullable()->constrained();
            $table->decimal('porcentaje_cargo', 6, 2)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('caja_movimientos', function (Blueprint $table) {
            //
        });
    }
}
