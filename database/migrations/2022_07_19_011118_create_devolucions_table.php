<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDevolucionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('devolucions', function (Blueprint $table) {
            $table->id();
            $table->morphs('placelable');
            $table->decimal('importe', 8, 2);
            $table->decimal('gastos_administrativos', 8, 2);
            $table->date('fecha');
            $table->text('observacion')->nullable();
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
        Schema::dropIfExists('devolucions');
    }
}
