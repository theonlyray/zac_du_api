<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompatibilityCertificatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('compatibility_certificates', function (Blueprint $table) {
            $table->id();
            $table->text('medidas_colindancia')
                ->nullable();
            // $table->double('m2_ocupacion')
            //     ->default(0.0)
            //     ->nullable();
            $table->text('uso_actual')
                ->nullable();
            $table->text('uso_propuesto')
                ->nullable();
            $table->text('usos_permitidos')
                ->nullable();
            $table->text('usos_prohibidos')
                ->nullable();
            $table->text('usos_condicionales')
                ->nullable();
            $table->text('observaciones')
                ->nullable();
            $table->text('resticciones')
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
        Schema::dropIfExists('compatibility_certificates');
    }
}
