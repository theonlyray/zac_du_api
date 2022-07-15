<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConstructionDescriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('construction_descriptions', function (Blueprint $table) {
            $table->id();
            $table->double('sotano')
                ->default(0.0)
                ->nullable();
            $table->double('planta_baja')
                ->default(0.0)
                ->nullable();
            $table->double('mezzanine')
                ->default(0.0)
                ->nullable();
            $table->double('primer_piso')
                ->default(0.0)
                ->nullable();
            $table->double('segundo_piso')
                ->default(0.0)
                ->nullable();
            $table->double('tercer_piso')
                ->default(0.0)
                ->nullable();
            $table->double('cuarto_piso')
                ->default(0.0)
                ->nullable();
            $table->double('quinto_piso')
                ->default(0.0)
                ->nullable();
            $table->double('sexto_piso')
                ->default(0.0)
                ->nullable();
            $table->double('descubierta')
                ->default(0.0)
                ->nullable();
            $table->double('sup_total_amp_reg_const')
                ->default(0.0)
                ->nullable();
            $table->string('descripcion', 650)
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
        Schema::dropIfExists('construction_descriptions');
    }
}
