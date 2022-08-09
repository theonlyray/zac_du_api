<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConstructionBackgroundsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('construction_backgrounds', function (Blueprint $table) {
            $table->id();
            $table->string('physical_prior_license_id', 35)
                ->nullable();
            $table->date('fecha')
                ->nullable();
            //? should be related but the first licenses will be from the previous process, so there will be no records
            $table->foreignId('prior_license_id')
                ->nullable()
                ->constrained('licenses');
            $table->foreignId('current_license_id')
                ->constrained('licenses')
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
        Schema::dropIfExists('construction_backgrounds');
    }
}
