<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUbicacionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ubicacions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ubigeo_id')->constrained();
            $table->foreignId('tipo_pista_id')->constrained();
            $table->string('descripcion');
            $table->string('codigo_iata')->nullable();
            $table->string('codigo_icao');
            $table->string('geo_longitud')->nullable();
            $table->string('geo_latitud')->nullable();
            $table->boolean('is_permited')->nullable()->default(false);
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
        Schema::dropIfExists('ubicacions');
    }
}
