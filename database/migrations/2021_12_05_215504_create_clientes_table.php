<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clientes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ubigeo_id')->nullable()->constrained();
            $table->string('ruc', 11);
            $table->text('razon_social');
            $table->text('nombre_comercial')->nullable();
            $table->text('descripcion')->nullable();
            $table->text('direccion')->nullable();
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
        Schema::dropIfExists('clientes');
    }
}
