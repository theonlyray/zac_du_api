<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderDutiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_duties', function (Blueprint $table) {
            $table->id();
            $table->decimal('precio', $precision = 8, $scale = 2);
            $table->decimal('cantidad', $precision = 8, $scale = 2);
            $table->decimal('total', $precision = 8, $scale = 2);
            $table->bigInteger('cuenta');
            $table->string('descripcion',255);
            $table->bigInteger('idCuenta');
            $table->foreignId('order_id')
                ->constrained('orders')
                ->onDelete('cascade');
            // $table->foreignId('duty_id')
            //     ->constrained('duties');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_duties');
    }
}
