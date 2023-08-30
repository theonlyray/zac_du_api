<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddObservationToSfd extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('s_f_d_s', function (Blueprint $table) {
            $table->text('observaciones')
                ->after('m2_ocupacion')
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
        Schema::table('s_f_d_s', function (Blueprint $table) {
            $table->dropColumn('observaciones');
        });
    }
}
