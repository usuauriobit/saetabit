<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAvionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('avions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tipo_motor_id')->nullable()->constrained();
            $table->foreignId('estado_avion_id')->nullable()->constrained();
            $table->foreignId('fabricante_id')->nullable()->constrained();
            $table->string('descripcion');
            $table->string('modelo')->nullable();
            $table->string('matricula');
            $table->integer('nro_asientos');
            $table->integer('nro_pilotos')->nullable();
            $table->decimal('peso_max_pasajeros', 8, 2);
            $table->decimal('peso_max_carga', 8, 2);
            $table->date('fecha_fabricacion')->nullable();
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
        Schema::dropIfExists('avions');
    }
}
