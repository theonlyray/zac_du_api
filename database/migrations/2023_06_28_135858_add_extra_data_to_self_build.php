<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddExtraDataToSelfBuild extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('self_builds', function (Blueprint $table) {
            $table->double('sup_total')
                ->default(0.0)
                ->after('coadyuvante')
                ->nullable();
            $table->string('calle', 255)
                ->after('sup_total')
                ->nullable();
            $table->string('colonia', 255)
                ->after('calle')
                ->nullable();
            $table->string('propietario', 255)
                ->after('colonia')
                ->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('self_builds', function (Blueprint $table) {
            //
        });
    }
}
