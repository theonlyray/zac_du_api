<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLicensesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('licenses', function (Blueprint $table) {
            $table->id();
            $table->string('folio', 50)
                ->nullable();
            $table->Integer('estatus')
                ->default(0);
            $table->timestamp('fecha_registro')
                ->useCurrent();
            $table->timestamp('fecha_actualizacion')
                ->useCurrent();
            $table->boolean('firmada')
                ->default(false);
            $table->foreignId('license_type_id')
                ->constrained('license_types');
            $table->foreignId('user_id')
                ->constrained('users');
            // $table->foreignId('property_id')
            //     ->constrained('properties');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('licenses');
    }
}
