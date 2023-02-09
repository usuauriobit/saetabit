<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdatePasaje2Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pasajes', function (Blueprint $table) {
            $table->foreignId('tipo_vuelo_id');
            $table->foreignId('origen_id')->constrained('ubicacions');
            $table->foreignId('destino_id')->constrained('ubicacions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pasajes', function (Blueprint $table) {
            //
        });
    }
}
