<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAperturaCierreIdToCajaMovimientos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('caja_movimientos', function (Blueprint $table) {
            $table->foreignId('apertura_cierre_id')->constrained('caja_apertura_cierres');
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
