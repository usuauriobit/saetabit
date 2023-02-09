<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIncidenciaAvionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('incidencia_avions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vuelo_id')->constrained();
            $table->foreignId('avion_before_id')->constrained('avions');
            $table->foreignId('avion_after_id')->constrained('avions');
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
        Schema::dropIfExists('incidencia_avions');
    }
}
