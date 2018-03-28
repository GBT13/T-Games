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

//        Use the associative array option to save time if you actually have all the used columns the same way in your database
        $data = json_decode($json);
        foreach ($data as $game) {
            Game::create(array(
                'appid' => $game->appid,
                'name' => $game->name,
                'developer' => $game->developer,
                'publisher' => $game->publisher
            ));
        }

    }
}
