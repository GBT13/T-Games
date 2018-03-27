<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('imageLocation')->nullable();
            $table->text('bio')->nullable();
            $table->string('steamid')->nullable();
            $table->string('psnName')->nullable();
            $table->string('xboxGamertag')->nullable();
            $table->string('originName')->nullable();
            $table->string('uplayName')->nullable();
            $table->string('battletag')->nullable();
            $table->string('discord')->nullable();
            $table->string('epicName')->nullable();
            $table->string('nintendoNetworkId')->nullable();
            $table->integer('country_id')->unsigned()->nullable();
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
        Schema::dropIfExists('profiles');
    }
}
