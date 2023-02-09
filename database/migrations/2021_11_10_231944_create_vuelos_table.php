<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVuelosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vuelos', function (Blueprint $table) {
            $table->id();
            $table->string('codigo');
            $table->foreignId('vuelo_ruta_id')->constrained();
            $table->foreignId('tipo_vuelo_id')->constrained();
            $table->foreignId('avion_id')->nullable()->constrained();
            $table->foreignId('origen_id')->constrained('ubicacions');
            $table->foreignId('destino_id')->constrained('ubicacions');

            $table->datetime('hora_despegue')->nullable();
            $table->datetime('hora_aterrizaje')->nullable();
            $table->datetime('fecha_hora_vuelo_programado')->nullable();
            $table->datetime('fecha_hora_aterrizaje_programado')->nullable();

            $table->integer('nro_asientos_ofertados')->unsigned()->default(0);
            $table->integer('stop_number')->unsigned()->default(0);
            $table->foreignId('user_confirmed_id')->nullable()->constrained('users');
            $table->date('fecha_confirmed')->nullable();
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
        Schema::dropIfExists('vuelos');
    }
}
