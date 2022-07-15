<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSFDSTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('s_f_d_s', function (Blueprint $table) {
            $table->id();
            $table->string('descripcion',255)
                ->comment('subdivision, fusion, desmembracion');
            $table->text('medidas_colindancia')
                ->nullable();
            $table->double('m2_ocupacion')
                ->default(0.0)
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
        Schema::dropIfExists('s_f_d_s');
    }
}
