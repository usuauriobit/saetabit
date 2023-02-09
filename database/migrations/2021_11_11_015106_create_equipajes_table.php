<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEquipajesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('equipajes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pasaje_id')->constrained();
            $table->foreignId('vuelo_id')->constrained();
            $table->decimal('peso', 10, 2);
            $table->decimal('importe', 10, 2);
            $table->decimal('igv', 10, 2);
            $table->decimal('descuento', 10, 2);
            $table->decimal('dimension_alto', 10, 2);
            $table->decimal('dimension_ancho', 10, 2);
            $table->decimal('dimension_largo', 10, 2);
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
        Schema::dropIfExists('equipajes');
    }
}
