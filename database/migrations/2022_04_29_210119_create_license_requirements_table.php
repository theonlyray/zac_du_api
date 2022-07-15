<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLicenseRequirementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('license_requirements', function (Blueprint $table) {
            $table->id();
            $table->string('archivo_nombre', 255)
                ->nullable();
            $table->string('archivo_ubicacion', 180)
                ->nullable();
            $table->string('archivo_url', 180)
                ->nullable();
            $table->string('comentario', 180)
                ->nullable();
            $table->Integer('estatus')
                ->default(0);
            $table->timestamp('fecha_registro')
                ->useCurrent();
            $table->timestamp('fecha_actualizacion')
                ->useCurrent();
            $table->timestamp('fecha_autorizacion')
                ->nullable();
            $table->foreignId('requirement_id')
                ->constrained('requirements')
                ->onDelete('cascade');
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
        Schema::dropIfExists('license_requirements');
    }
}
