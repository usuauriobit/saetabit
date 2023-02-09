<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVueloCreditosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vuelo_creditos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vuelo_ruta_id')->constrained('vuelo_rutas');
            $table->morphs('clientable');
            $table->date('fecha_pago')->nullable();
            $table->boolean('is_pagado')->nullable()->default(false);
            $table->string('glosa')->nullable();
            $table->decimal('monto', 10, 2);
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
        Schema::dropIfExists('charter_creditos');
    }
}
