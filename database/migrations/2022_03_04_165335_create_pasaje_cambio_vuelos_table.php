<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePasajeCambioVuelosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pasaje_cambio_vuelos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vuelo_id')->constrained();
            $table->foreignId('pasaje_cambio_id')->constrained();
            $table->boolean('is_anterior')->default(true);
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
        Schema::dropIfExists('pasaje_cambio_vuelos');
    }
}
