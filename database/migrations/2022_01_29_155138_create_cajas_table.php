<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCajasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cajas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('oficina_id')->constrained();
            $table->string('descripcion');
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
        Schema::dropIfExists('cajas');
    }
}
