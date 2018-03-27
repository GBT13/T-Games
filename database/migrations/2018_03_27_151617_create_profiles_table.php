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
            $table->text('bioText')->nullable();
            $table->text('steamname')->nullable();
            $table->text('playstationname')->nullable();
            $table->text('xboxname')->nullable();
            $table->text('discordname')->nullable();
            $table->text('epicname')->nullable();
            $table->text('nintendoname')->nullable();
            $table->text('eaname')->nullable();
            $table->text('uplayname')->nullable();
            $table->text('blizzardname')->nullable();
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
