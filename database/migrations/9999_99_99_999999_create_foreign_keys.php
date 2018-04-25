<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateForeignKeys extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('profiles', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')->onDelete('CASCADE');
        });

        Schema::table('game_profile', function (Blueprint $table) {
            $table->foreign('game_id')->references('id')->on('games')->onDelete('CASCADE');
            $table->foreign('profile_id')->references('id')->on('profiles')->onDelete('CASCADE');
        });

        Schema::table('matches', function (Blueprint $table) {
           $table->foreign('profile_id')->references('id')->on('profiles')->onDelete('CASCADE');
           $table->foreign('partner_profile_id')->references('id')->on('profiles')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::disableForeignKeyConstraints();
    }
}
