<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLPSeccionHeroesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('l_p_seccion_heroes', function (Blueprint $table) {
            $table->id();
            $table->string('title', 200)->nullable();
            $table->string('subtitle', 500)->nullable();
            $table->string('path_bg', 500)->nullable();
            $table->string('path_img', 500)->nullable();
            $table->integer('nro_orden')->default(1);
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
        Schema::dropIfExists('l_p_seccion_heroes');
    }
}
