<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddApprovedToCambiosTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        $tables = [
            'pasaje_cambios',
            'pasaje_liberacion_historials',
        ];
        foreach ($tables as $table) {
            Schema::table($table, function (Blueprint $table) {
                $table->foreignId('approved_by_id')->nullable()->constrained('users');
                $table->string('approved_observation', 500)->nullable();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cambios_tables', function (Blueprint $table) {
            //
        });
    }
}
