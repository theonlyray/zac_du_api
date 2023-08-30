<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCommunityToProperty extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('property_descriptions', function (Blueprint $table) {
            $table->string('comunidad', 150)
                ->after('clave_catastral')
                ->default('N/A');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('property_descriptions', function (Blueprint $table) {
            $table->dropColumn('comunidad');
        });
    }
}
