<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFileToObservation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('license_observations', function (Blueprint $table) {
            $table->string('url', 255)
                ->after('solventada')
                ->nullable();
                $table->string('path', 255)
                ->after('url')
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
        Schema::table('license_observations', function (Blueprint $table) {
            $table->dropColumn('url');
            $table->dropColumn('path');
        });
    }
}
