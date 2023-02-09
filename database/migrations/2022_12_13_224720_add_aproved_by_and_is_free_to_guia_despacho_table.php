<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAprovedByAndIsFreeToGuiaDespachoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('guia_despachos', function (Blueprint $table) {
            $table->foreignId('approved_by_id')->nullable()->constrained('users');
            $table->boolean('is_free')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('guia_despachos', function (Blueprint $table) {
            //
        });
    }
}
