<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCajaTipoComprobantesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('caja_tipo_comprobantes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('caja_id')->constrained();
            $table->foreignId('tipo_comprobante_id')->constrained();
            $table->string('serie');
            $table->string('correlativo_inicial')->nullable();
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
        Schema::dropIfExists('caja_tipo_comprobantes');
    }
}
