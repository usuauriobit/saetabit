<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePasajeCambioTarifasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pasaje_cambio_tarifas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('categoria_vuelo_id');
            $table->decimal('monto_cambio_fecha', 10, 2);
            $table->decimal('monto_cambio_abierto', 10, 2);
            $table->decimal('monto_cambio_titularidad', 10, 2);
            $table->decimal('monto_cambio_ruta', 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pasaje_cambio_tarifas');
    }
}
