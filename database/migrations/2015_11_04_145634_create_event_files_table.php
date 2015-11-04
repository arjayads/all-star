<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_files', function (Blueprint $table) {

            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->unsignedInteger('event_id');
            $table->unsignedInteger('file_id');

            $table->foreign('event_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('file_id')->references('id')->on('groups')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('event_files');
    }
}
