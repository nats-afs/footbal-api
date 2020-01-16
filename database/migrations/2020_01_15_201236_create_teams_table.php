<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teams', function (Blueprint $table) {
            $table->integer('id');
            $table->string('name');
            $table->string('shortName');
            $table->string('tla');
            $table->string('crestUrl')->nullable();
            $table->string('address');
            $table->string('phone');
            $table->string('website');
            $table->string('email')->nullable();
            $table->integer('founded');
            $table->string('clubColors');
            $table->string('venue');
            $table->dateTime('lastUpdated');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('teams');
    }
}