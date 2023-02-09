<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCajaAperturaCierreBilletesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('caja_apertura_cierre_billetes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('apertura_cierre_id')->constrained('caja_apertura_cierres');
            $table->foreignId('denominacion_id')->constrained('denominacion_billetes');
            $table->integer('cantidad');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('caja_apertura_cierre_billetes');
    }
}
