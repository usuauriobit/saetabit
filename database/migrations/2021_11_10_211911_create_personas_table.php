<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePersonasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('personas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tipo_documento_id')->nullable()->constrained();
            $table->foreignId('ubigeo_id')->nullable()->constrained();
            $table->foreignId('lugar_nacimiento_id')->nullable()->constrained('ubigeos');
            $table->string('apellido_paterno')->nullable();
            $table->string('apellido_materno')->nullable();
            $table->string('nro_doc')->nullable();
            // $table->string('ruc')->nullable();
            // $table->string('razon_social')->nullable();
            $table->string('nombres');
            $table->boolean('sexo')->nullable()->default(true);
            $table->date('fecha_nacimiento')->nullable();
            $table->string('photo_url')->nullable();
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
        Schema::dropIfExists('personas');
    }
}
