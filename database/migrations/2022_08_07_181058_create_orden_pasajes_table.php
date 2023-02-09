<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdenPasajesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orden_pasajes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vuelo_origen_id');
            $table->foreignId('vuelo_destino_id');
            $table->boolean('is_ida_vuelta')->default(false);
            $table->string('codigo', 100)->unique();
            $table->dateTime('fecha');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orden_pasajes');
    }
}
