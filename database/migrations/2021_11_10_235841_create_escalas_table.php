<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEscalasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('escalas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vuelo_id')->constrained();
            $table->foreignId('escala_origen_id')->nullable()->constrained('ubicacions');
            $table->foreignId('escala_id')->constrained('ubicacions');
            $table->time('hora_programada_aterrizaje')->nullable();
            $table->time('hora_programada_despegue')->nullable();
            $table->time('hora_aterrizaje')->nullable();
            $table->time('hora_despegue')->nullable();
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
        Schema::dropIfExists('escalas');
    }
}
