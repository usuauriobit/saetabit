<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIncidenciaTripulacionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('incidencia_tripulacions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vuelo_id')->constrained();
            $table->foreignId('tripulacion_vuelo_before_id')->constrained('tripulacion_vuelos');
            $table->foreignId('tripulacion_vuelo_after_id')->constrained('tripulacion_vuelos');
            $table->string('descripcion');
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
        Schema::dropIfExists('incidencia_tripulacions');
    }
}
