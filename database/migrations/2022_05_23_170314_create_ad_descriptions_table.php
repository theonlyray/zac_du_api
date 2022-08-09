<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdDescriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ad_descriptions', function (Blueprint $table) {
            $table->id();
            $table->string('colocacion', 255)
                ->nullable();
            // $table->boolean('colocacion')
            //     ->default(true)
            //     ->comment('If true, its an ad placement, otherwise renewal');
            $table->string('tipo', 255);
            $table->integer('cantidad')
                ->default(1);
            $table->double('largo')
                ->default(0.0);
            $table->double('ancho')
                ->default(0.0);
            $table->double('alto')
                ->default(0.0);
            $table->string('colores', 255)
                ->nullable();
            $table->string('texto', 255)
                ->nullable();
            $table->date('fecha_inicio')
                ->nullable();
            $table->date('fecha_fin')
                ->nullable();
            $table->foreignId('license_id')
                ->constrained('licenses')
                ->unique()
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
        Schema::dropIfExists('ad_descriptions');
    }
}
