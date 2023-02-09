<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTipoPasajesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tipo_pasajes', function (Blueprint $table) {
            $table->id();
            $table->string('descripcion');
            $table->string('abreviatura');
            $table->integer('edad_minima');
            $table->integer('edad_maxima');
            $table->boolean('ocupa_asiento')->default(false);
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
        Schema::dropIfExists('tipo_pasajes');
    }
}
