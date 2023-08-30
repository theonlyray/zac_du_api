<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFirmadoFielLicenseRequirementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('license_requirements', function (Blueprint $table) {
            $table->boolean('firmado')
            ->after('estatus')
            ->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('license_requirements', function (Blueprint $table) {
            $table->dropColumn('firmado');
        });
    }
}
