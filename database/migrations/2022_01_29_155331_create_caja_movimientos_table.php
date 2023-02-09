<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCajaMovimientosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('caja_movimientos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('caja_id')->constrained();
            $table->foreignId('tipo_movimiento_id')->constrained();
            // $table->foreignId('categoria_movimiento_caja_id')->constrained();
            $table->morphs('documentable');
            // $table->morphs('destinable');
            $table->decimal('monto', 10, 2);
            $table->dateTime('fecha');
            $table->timestamps();
            $table->softDeletes();

            $table->foreignId('created_user_id')->nullable()->constrained('users');
            $table->foreignId('updated_user_id')->nullable()->constrained('users');
            $table->foreignId('deleted_user_id')->nullable()->constrained('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('caja_movimientos');
    }
}
