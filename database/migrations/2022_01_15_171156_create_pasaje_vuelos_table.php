<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePasajeVuelosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pasaje_vuelos', function (Blueprint $table) {
            $table->id('id');
            $table->foreignId('pasaje_id')->constrained();
            $table->foreignId('vuelo_id')->constrained();
            $table->dateTime('checkin_date')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreignId('user_created_id')->nullable()->constrained('users');
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
        Schema::dropIfExists('pasaje_vuelos');
    }
}
