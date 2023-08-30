<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBarracksToProperty extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('property_descriptions', function (Blueprint $table) {
            $table->string('cuartel', 255)
                ->after('comunidad')
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
        Schema::table('property_descriptions', function (Blueprint $table) {
            $table->dropColumn('cuartel');
        });
    }
}
