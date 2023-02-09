<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIncidenciaFechasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('incidencia_fechas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vuelo_id');
            $table->dateTime('fecha_hora_vuelo_anterior');
            $table->dateTime('fecha_hora_aterrizaje_anterior');
            $table->dateTime('fecha_hora_vuelo_posterior');
            $table->dateTime('fecha_hora_aterrizaje_posterior');
            $table->string('descripcion')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreignId('user_created_id')->constrained('users');
            $table->foreignId('user_updated_id')->nullable()->constrained('users');
            $table->foreignId('user_deleted_id')->nullable()->constrained('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('incidencia_fechas');
    }
}
