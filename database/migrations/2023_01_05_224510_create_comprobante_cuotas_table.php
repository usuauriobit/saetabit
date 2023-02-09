<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComprobanteCuotasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comprobante_cuotas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('comprobante_id')->constrained();
            $table->integer('nro_cuota');
            $table->date('fecha_pago');
            $table->decimal('importe', 8, 2);
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
        Schema::dropIfExists('comprobante_cuotas');
    }
}
