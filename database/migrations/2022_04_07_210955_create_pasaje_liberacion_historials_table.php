<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePasajeLiberacionHistorialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pasaje_liberacion_historials', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pasaje_id');
            $table->foreignId('pasaje_vuelo_anterior_id')->nullable();
            $table->foreignId('pasaje_vuelo_nuevo_id')->nullable();
            $table->string('codigo_historial', 100);
            $table->string('nota', 500)->nullable();
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
        Schema::dropIfExists('pasaje_liberacion_historials');
    }
}
