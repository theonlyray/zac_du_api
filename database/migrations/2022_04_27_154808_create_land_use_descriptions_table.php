<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLandUseDescriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('land_use_descriptions', function (Blueprint $table) {
            $table->id();
            $table->string('descripcion');
            $table->decimal('uma', 10,4)
                ->default(0);
            $table->timestamp('fecha_registro')
                ->useCurrent();
            $table->timestamp('fecha_actualizacion')
                ->useCurrent();
            $table->foreignId('land_use_id')
                ->constrained('land_uses')
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
        Schema::dropIfExists('land_use_descriptions');
    }
}
