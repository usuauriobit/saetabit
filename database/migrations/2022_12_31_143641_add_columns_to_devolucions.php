<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToDevolucions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('devolucions', function (Blueprint $table) {
            $table->foreignId('banco_id')->constrained();
            $table->string('nro_cuenta_bancaria')->nullable();
            $table->foreignId('reviewed_by_id')->nullable()->constrained('users');
            $table->enum('status_reviewed', ['Aprobado', 'Rechazado', 'En Evaluación'])->default('En Evaluación')->nullable();
            $table->date('date_reviewed')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('devolucions', function (Blueprint $table) {
            //
        });
    }
}
