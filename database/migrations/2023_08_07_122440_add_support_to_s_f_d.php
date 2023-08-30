<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSupportToSFD extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('s_f_d_s', function (Blueprint $table) {
            $table->string('sustento', 255)
            ->after('actividad')
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
            $table->dropColumn('sustento');
        });
    }
}
