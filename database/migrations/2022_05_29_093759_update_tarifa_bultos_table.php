<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateTarifaBultosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tarifa_bultos', function (Blueprint $table) {
            $table->foreignId('tipo_bulto_id')->constrained();
            $table->boolean('is_monto_editable')->default(false);
            $table->boolean('is_monto_fijo')->default(false);
            $table->boolean('is_equipaje')->nullable()->default(false);
            // $table->boolean('has_limite')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tarifa_bultos', function (Blueprint $table) {
            //
        });
    }
}
