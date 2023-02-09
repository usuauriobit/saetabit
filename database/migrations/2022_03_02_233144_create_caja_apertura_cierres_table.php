<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCajaAperturaCierresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('caja_apertura_cierres', function (Blueprint $table) {
            $table->id();
            $table->foreignId('caja_id')->constrained();
            $table->datetime('fecha_apertura');
            $table->datetime('fecha_cierre')->nullable();
            $table->text('observacion_apertura')->nullable();
            $table->foreignId('created_user_id')->constrained('users');
            $table->foreignId('updated_user_id')->nullable()->constrained('users');
            $table->foreignId('deleted_user_id')->nullable()->constrained('users');
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
        Schema::dropIfExists('caja_apertura_cierres');
    }
}
