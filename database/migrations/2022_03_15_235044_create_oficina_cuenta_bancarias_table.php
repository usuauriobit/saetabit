<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOficinaCuentaBancariasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('oficina_cuenta_bancarias', function (Blueprint $table) {
            $table->id();
            $table->foreignId('oficina_id')->constrained();
            $table->foreignId('banco_id')->constrained();
            $table->string('nro_cuenta');
            $table->string('nro_cci');
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
        Schema::dropIfExists('oficina_cuenta_bancarias');
    }
}
