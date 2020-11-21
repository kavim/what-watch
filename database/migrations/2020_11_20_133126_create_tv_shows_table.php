<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTvShowsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tv_shows', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->longText('synopsis');
            $table->unsignedSmallInteger('year')->nullable();
            $table->unsignedTinyInteger('seasons_quantity')->nullable();
            

            $table->unsignedBigInteger('category_id');
            $table->foreign('category_id')->references('id')->on('categories');
            
            $table->unsignedBigInteger('status_id');
            $table->foreign('status_id')->references('id')->on('statuses');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tv_shows');
    }
}
