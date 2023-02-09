<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToComprobanteFacturacionRespuestas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('comprobante_facturacion_respuestas', function (Blueprint $table) {
            $table->string('enlace_del_pdf')->after('enlace')->nullable();
            $table->string('enlace_del_xml')->after('enlace_del_pdf')->nullable();
            $table->string('enlace_del_cdr')->after('enlace_del_xml')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('comprobante_facturacion_respuestas', function (Blueprint $table) {
            //
        });
    }
}
