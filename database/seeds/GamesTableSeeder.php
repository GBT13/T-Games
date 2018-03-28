<?php

use App\Game;
use Illuminate\Database\Seeder;

class GamesTableSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        try {
            $json = File::get("database/gamedata/top100Games.json");

//            This one might be slight overkill
//            $json = File::get("database/gamedata/allsteamgames.json");
        } catch (\Illuminate\Contracts\Filesystem\FileNotFoundException $e) {

        }
        $data = json_decode($json, true);
        foreach ($data as $game) {
            Game::create($game);
        }

    }
}
