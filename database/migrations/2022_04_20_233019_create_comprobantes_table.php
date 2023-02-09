<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComprobantesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comprobantes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('venta_id')->nullable()->constrained();
            $table->foreignId('caja_apertura_cierre_id')->nullable()->constrained();
            $table->foreignId('moneda_id')->constrained();
            $table->foreignId('tipo_documento_id')->constrained();
            $table->foreignId('tipo_comprobante_id')->constrained();
            $table->foreignId('tipo_pago_id')->constrained();
            $table->string('serie');
            $table->string('correlativo');
            $table->string('nro_documento');
            $table->string('denominacion');
            $table->string('direccion')->nullable();
            $table->date('fecha_emision');
            $table->date('fecha_vencimiento');
            $table->foreignId('created_user_id')->constrained('users');
            $table->foreignId('updated_user_id')->nullable()->constrained('users');
            $table->timestamps();
            $table->foreignId('deleted_user_id')->nullable()->constrained('users');
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
        Schema::dropIfExists('comprobantes');
    }
}
