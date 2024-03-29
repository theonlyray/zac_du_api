<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePropertiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('property_descriptions', function (Blueprint $table) {
            $table->id();
            $table->string('calle', 355);
            $table->string('no', 50);
            $table->string('colonia', 255);
            $table->string('seccion', 50)
                ->nullable();
            $table->string('manzana', 50)
                ->nullable();
            $table->string('lote', 50)
                ->nullable();
            $table->string('no_predial', 80)
                ->nullable();
            $table->string('clave_catastral', 80)
                ->default('N/A');
            // $table->string('comunidad', 150)
            //     ->default('N/A');
                // ->unique();
            $table->double('sup_terreno')
                ->default(0.0)
                ->nullable();
            $table->double('sup_construida')
                ->default(0.0)
                ->nullable();
            $table->double('sup_no_construida')
                ->default(0.0)
                ->nullable();
            $table->boolean('agua')
                ->default(false);
            $table->boolean('luz')
                ->default(false);
            $table->boolean('drenaje')
                ->default(false);
            $table->decimal('latitud', 10,7)
                ->default(22.7743376);
            $table->decimal('longitud', 11,7)
                ->default(-102.5879641);
            $table->string('mapa_ubicacion', 180)
                ->nullable();
            $table->string('mapa_url', 180)
                ->nullable();
            $table->string('poligono', 80)
                ->default('Colonias Populares');
            $table->timestamp('fecha_registro')
                ->useCurrent();
            $table->timestamp('fecha_actualizacion')
                ->useCurrent();
            $table->foreignId('license_id')
                ->constrained('licenses')
                ->unique()
                ->onDelete('cascade');
        });

        //add column "comunidad" to properties table
        Schema::table('properties', function (Blueprint $table) {
            $table->string('comunidad', 150)
                ->default('N/A')
                ->after('clave_catastral');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('property_descriptions');
    }
}
