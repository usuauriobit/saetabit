<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateTarifasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tarifas', function (Blueprint $table) {
            $table->boolean('is_dolarizado')->default(false);
            // $table->boolean('is_default')->nullable()->default(false);
            // $table->decimal('dias_anticipacion', 5, 2)->nullable()->default();
            // $table->decimal('ultimo_cupo', 5, 2)->nullable()->default();
            // $table->decimal('cantidad', 5, 2)->nullable()->default();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tarifas', function (Blueprint $table) {
            //
        });
    }
}
