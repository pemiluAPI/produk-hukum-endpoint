<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRegulationsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('regulations', function(Blueprint $table) {
        
            $table->increments('id');
            $table->integer('category_id')->unsigned();
            $table->text('title');
            $table->text('description')->nullable();
            $table->string('file_url')->nullable();
            $table->string('url')->nullable();
            $table->nullableTimestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('regulations');
    }
}
