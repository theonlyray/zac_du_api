<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddResolucionColumnToCompatibilityCertificateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('compatibility_certificates', function (Blueprint $table) {
            $table->string('resolucion', 255)
            ->after('resticciones')
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
        Schema::table('compatibility_certificates', function (Blueprint $table) {
            $table->dropColumn('resolucion');
        });
    }
}
