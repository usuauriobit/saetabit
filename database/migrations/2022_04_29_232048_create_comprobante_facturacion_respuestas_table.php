<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComprobanteFacturacionRespuestasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comprobante_facturacion_respuestas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('comprobante_id')->constrained();
            $table->string('tipo_de_comprobante')->nullable();
            $table->string('serie')->nullable();
            $table->string('numero')->nullable();
            $table->string('enlace')->nullable();
            $table->string('aceptada_por_sunat')->nullable();
            $table->string('sunat_description')->nullable();
            $table->string('sunat_note')->nullable();
            $table->string('sunat_responsecode')->nullable();
            $table->string('sunat_soap_error')->nullable();
            $table->string('cadena_para_codigo_qr')->nullable();
            $table->string('codigo_hash')->nullable();
            $table->text('errors')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comprobante_facturacion_respuestas');
    }
}
