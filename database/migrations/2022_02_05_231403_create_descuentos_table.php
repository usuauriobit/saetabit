<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDescuentosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('descuentos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tipo_descuento_id')->constrained();
            $table->foreignId('tipo_pasaje_id')->constrained();
            $table->foreignId('ruta_id')->nullable()->constrained();
            $table->string('descripcion', 500);
            $table->string('codigo_cupon', 500)->nullable();
            $table->decimal('cantidad', 6, 2)->nullable()->default(0);
            $table->decimal('descuento_porcentaje', 6, 2)->nullable()->default(0);
            $table->decimal('descuento_monto', 6, 2)->nullable()->default(0);
            $table->decimal('descuento_fijo', 6, 2)->nullable()->default(0);

            $table->integer('nro_maximo')->nullable();
            $table->date('fecha_expiracion')->nullable();

            $table->integer('dias_anticipacion')->nullable();
            // $table->integer('minimo_nro_cupos')->nullable();
            // $table->integer('minimo_ultimo_cupo')->nullable();

            $table->boolean('is_interno')->default(false);
            // $table->boolean('is_for_ida_vuelta')->default(false);
            // $table->boolean('is_ultimos_cupos')->default(false);
            $table->boolean('is_automatico')->default(false);

            $table->integer('edad_minima')->nullable();
            $table->integer('edad_maxima')->nullable();


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
        Schema::dropIfExists('tipo_descuento_rutas');
    }
}
