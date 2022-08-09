<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('files', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 180)
                ->nullable();
            $table->string('ubicacion', 180)
                ->nullable();
            $table->string('url', 180)
                ->nullable();
            $table->timestamp('fecha_registro')
                ->useCurrent();
            $table->timestamp('fecha_actualizacion')
                ->useCurrent();
            $table->boolean('para')
                ->default(true)
                ->nullable()
                ->comment('true - dro | false - particular');
            $table->foreignId('college_id')
                ->nullable()
                ->constrained('colleges');
            $table->foreignId('user_id')
                ->constrained('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('files');
    }
}
