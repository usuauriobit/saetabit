<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVueloMassivesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vuelo_massives', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tipo_vuelo_id')->constrained();
            $table->foreignId('ruta_id')->constrained();
            $table->date('fecha_inicio');
            $table->date('fecha_final');
            $table->float('nro_asientos')->nullable();
            $table->string('paquete')->nullable();
            $table->string('nro_contrato')->nullable();
            $table->foreignId('cliente_id')->nullable()->constrained();
            $table->decimal('monto_total', 10, 2)->nullable()->nullable();
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
        Schema::dropIfExists('vuelo_massives');
    }
}
