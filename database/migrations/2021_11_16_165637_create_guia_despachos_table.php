<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGuiaDespachosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('guia_despachos', function (Blueprint $table) {
            $table->id();
            // $table->foreignId('ruta_id')->constrained();
            $table->foreignId('origen_id')->constrained('ubicacions');
            $table->foreignId('destino_id')->constrained('ubicacions');
            $table->foreignId('remitente_id')->constrained('personas');
            $table->foreignId('consignatario_id')->constrained('personas');
            $table->foreignId('oficina_id')->constrained();
            $table->string('codigo')->unique();
            $table->dateTime('fecha');
            $table->dateTime('fecha_entrega')->nullable();
            // $table->decimal('igv', 8, 2);
            $table->timestamps();
            $table->softDeletes();
            $table->foreignId('user_created_id')->nullable()->constrained('users');
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
        Schema::dropIfExists('guia-despachos');
    }
}
