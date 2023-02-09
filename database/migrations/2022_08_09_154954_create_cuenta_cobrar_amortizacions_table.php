<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCuentaCobrarAmortizacionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cuenta_cobrar_amortizacions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cuenta_cobrar_id')->constrained();
            $table->dateTime('fecha_pago')->nullable();
            $table->decimal('monto', 10, 2);
            $table->string('nro_cuenta', 100)->nullable();
            $table->string('descripcion_cuenta', 100)->nullable();
            $table->string('glosa', 100)->nullable();
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
        Schema::dropIfExists('cuenta_cobrar_amortizacions');
    }
}
