<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePasajesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pasajes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tipo_pasaje_id')->constrained();
            $table->foreignId('pasajero_id')->constrained('personas');
            $table->foreignId('oficina_id')->nullable()->constrained();
            $table->decimal('importe', 10, 2);
            $table->decimal('monto_descuento', 10, 2)->nullable();
            $table->decimal('importe_final', 10, 2)->nullable();
            // $table->decimal('igv', 10, 2)->nullable();
            // $table->decimal('descuento', 10, 2)->nullable();
            $table->string('nro_asiento')->nullable();
            $table->decimal('peso_persona', 10, 2)->nullable();
            $table->date('fecha');
            $table->string('descripcion', 2000)->nullable();
            $table->string('telefono')->nullable();
            $table->string('email')->nullable();
            $table->boolean('is_asistido')->default(false);
            $table->boolean('is_abierto')->default(false);
            $table->boolean('is_asiento_libre')->default(false);
            $table->boolean('is_compra_web')->default(false);
            $table->boolean('is_caducado')->nullable()->default(false);
            $table->timestamps();
            $table->softDeletes();
            $table->dateTime('fecha_was_abierto')->nullable();
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
        Schema::dropIfExists('pasajes');
    }
}
