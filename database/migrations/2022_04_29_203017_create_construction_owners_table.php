<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConstructionOwnersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('construction_owners', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_apellidos', 255)
                ->nullable();
            $table->string('rfc', 25)
                ->nullable();
            $table->string('domicilio', 455)
                ->nullable();
            $table->string('ocupacion', 255)
                ->nullable();
            $table->string('telefono', 10)
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
        Schema::dropIfExists('construction_owners');
    }
}
