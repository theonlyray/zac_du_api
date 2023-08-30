<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLotsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lots', function (Blueprint $table) {
            $table->id();
            $table->string('colonia', 255);
            $table->string('seccion', 50)
                ->nullable();
            $table->string('manzana', 50)
                ->nullable();
            $table->string('lote', 50)
                ->nullable();
            $table->string('clave_catastral', 80)
                ->default('N/A');
            $table->double('sup_terreno')
                ->default(0.0)
                ->nullable();
            $table->timestamps();
            $table->foreignId('license_id')
                ->constrained('licenses')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lots');
    }
}
