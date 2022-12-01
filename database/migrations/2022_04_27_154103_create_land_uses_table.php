<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLandUsesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('land_uses', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->timestamp('fecha_registro')
                ->useCurrent();
            $table->timestamp('fecha_actualizacion')
                ->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('land_uses');
    }
}
