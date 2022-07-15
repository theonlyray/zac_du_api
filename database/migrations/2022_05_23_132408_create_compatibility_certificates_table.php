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
            $table->double('m2_ocupacion')
                ->default(0.0)
                ->nullable();
            $table->string('uso_actual', 180)
                ->nullable();
            $table->string('uso_propuesto', 180)
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
