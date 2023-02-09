<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGuiaDespachoDetallesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('guia_despacho_detalles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('guia_despacho_id')->constrained();
            $table->string('descripcion');
            $table->decimal('cantidad', 8, 2)->nullable()->default(1);
            $table->decimal('largo', 8, 2)->nullable();
            $table->decimal('ancho', 8, 2)->nullable();
            $table->decimal('alto', 8, 2)->nullable();
            $table->decimal('peso', 8, 2);
            $table->decimal('importe', 8, 2);
            $table->boolean('is_sobre')->default(false);
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
        Schema::dropIfExists('guia_despacho_detalles');
    }
}
