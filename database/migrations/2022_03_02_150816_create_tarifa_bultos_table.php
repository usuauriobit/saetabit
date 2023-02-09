<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTarifaBultosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tarifa_bultos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tipo_vuelo_id')->constrained();
            $table->decimal('peso_max', 5, 2);
            $table->decimal('monto_kg_excedido', 5, 2);
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
        Schema::dropIfExists('tarifa_bultos');
    }
}
