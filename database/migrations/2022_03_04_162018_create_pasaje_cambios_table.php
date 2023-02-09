<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePasajeCambiosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pasaje_cambios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tipo_pasaje_cambio_id')->constrained();

            $table->foreignId('pasajero_anterior_id')->nullable()->constrained('personas');
            $table->foreignId('pasajero_nuevo_id')->nullable()->constrained('personas');

            $table->foreignId('pasaje_id')->constrained();
            $table->decimal('importe_penalidad', 10, 2)->nullable()->default(0);
            $table->decimal('importe_adicional', 10, 2)->nullable()->default(0);

            $table->boolean('is_confirmado')->nullable()->default(false);
            // $table->boolean('is_rechazado')->nullable()->default(false);
            $table->foreignId('user_autorize_id')->nullable()->constrained('users');
            $table->dateTime('fecha_autorize')->nullable();
            // $table->decimal('igv', 10, 2);
            // $table->decimal('descuento', 10, 2);
            $table->text('nota')->nullable();
            $table->boolean('is_sin_pagar')->default(false);
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
        Schema::dropIfExists('pasaje_cambios');
    }
}
