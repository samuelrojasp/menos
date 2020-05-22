<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeyToTransaccionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('transacciones', function (Blueprint $table) {
            $table->foreign('mshop_order_id')->references('id')->on('mshop_order');
            $table->foreign('tipo_transaccion_id')->references('id')->on('tipos_transaccion');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('transacciones', function (Blueprint $table) {
            $table->dropForeign('transacciones_mshop_order_id_foreign');
            $table->dropForeign('transacciones_tipo_transaccion_id_foreign');
        });
    }
}
