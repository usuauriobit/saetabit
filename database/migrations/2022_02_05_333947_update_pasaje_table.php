<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdatePasajeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pasajes', function (Blueprint $table) {
            $table->foreignId('descuento_id')->nullable()->constrained();
            $table->foreignId('tarifa_id')->nullable()->constrained();
            $table->dateTime('checkin_date_time')->nullable();
            $table->string('codigo', 100);
            $table->string('observacion_anulado')->nullable();
            $table->decimal('importe_final_soles', 5, 2)->nullable();
            $table->decimal('tasa_cambio', 5, 2)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pasajes', function (Blueprint $table) {
            //
        });
    }
}
