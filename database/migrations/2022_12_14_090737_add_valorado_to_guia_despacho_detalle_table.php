<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddValoradoToGuiaDespachoDetalleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('guia_despacho_detalles', function (Blueprint $table) {
            $table->boolean('is_valorado')->default(false);
            $table->decimal('monto_valorado', 10, 2)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('guia_despacho_detalles', function (Blueprint $table) {
            //
        });
    }
}
