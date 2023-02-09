<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIncidenciaEscalasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('incidencia_escalas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vuelo_primario_id')->constrained('vuelos');
            $table->foreignId('escala_ubicacion_id')->constrained('ubicacions');
            $table->foreignId('vuelo_secundario_generado_id')->constrained('vuelos');
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
        Schema::dropIfExists('incidencia_escalas');
    }
}
