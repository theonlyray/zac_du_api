<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApplicantDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('applicant_data', function (Blueprint $table) {
            $table->id();
            $table->string('celular', 15)
                ->nullable();
            $table->string('rfc', 50);
            $table->string('no_registro', 50);
            $table->string('calle', 350)
                ->nullable();
            $table->string('no', 30)
                ->nullable();
            $table->string('colonia', 250)
                ->nullable();
            $table->string('cp', 5)
                ->nullable();
            $table->string('ocupacion', 155)
                ->nullable();
            $table->foreignId('user_id')
                ->constrained('users')
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
        Schema::dropIfExists('applicant_data');
    }
}
