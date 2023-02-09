<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePasajeBultosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pasaje_bultos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pasaje_id')->constrained();
            $table->string('descripcion')->nullable();

            $table->decimal('cantidad', 5, 2)->default(1);

            $table->decimal('peso_total', 5, 2)->nullable()->default(0);

            $table->decimal('peso_excedido', 5, 2)->nullable();
            $table->decimal('monto_exceso', 10, 2)->nullable(0);
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
        Schema::dropIfExists('pasaje_bultos');
    }
}
