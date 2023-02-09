<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVueloRutasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vuelo_rutas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tipo_vuelo_id')->constrained('tipo_vuelos');

            $table->foreignId('origen_id')->nullable()->constrained('ubicacions');
            $table->foreignId('destino_id')->nullable()->constrained('ubicacions');

            $table->datetime('fecha_hora_vuelo_programado')->nullable();
            $table->datetime('fecha_hora_aterrizaje_programado')->nullable();

            $table->softDeletes();
            $table->foreignId('user_created_id')->constrained('users');
            $table->foreignId('user_updated_id')->nullable()->constrained('users');
            $table->foreignId('user_deleted_id')->nullable()->constrained('users');
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
        Schema::dropIfExists('vuelo_rutas');
    }
}
