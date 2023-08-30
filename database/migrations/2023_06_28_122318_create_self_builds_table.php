<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSelfBuildsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('self_builds', function (Blueprint $table) {
            $table->id();
            $table->string('tipo_obra', 355)
                ->nullable();
            $table->string('construction', 355)
                ->nullable();
            $table->string('nivel', 355)
                ->nullable();
            $table->text('coadyuvante')
                ->nullable();
            $table->timestamps();
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
        Schema::dropIfExists('self_builds');
    }
}
