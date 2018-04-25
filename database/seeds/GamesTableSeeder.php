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
//            $json = File::get("database/gamedata/top100Games.json");

//            This one might be slight overkill
            $json = File::get("database/gamedata/allsteamgames.json");
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

        Game::create([
            'name'=>'Overwatch',
            'developer'=>'Blizzard Entertainment',
        ]);

        Game::create([
            'name'=>'Hearthstone',
            'developer'=>'Blizzard Entertainment',
        ]);

        Game::create([
            'name'=>'League of Legends',
            'developer'=>'Riot Games',
        ]);

        Game::create([
            'name'=>'Fortnite',
            'developer'=>'Epic Games',
        ]);

        Game::create([
            'name'=>'World of Warcraft',
            'developer'=>'Blizzard Entertainment',
        ]);

        Game::create([
            'name'=>'Starcraft 2',
            'developer'=>'Blizzard Entertainment',
        ]);

        Game::create([
            'name'=>'Starcraft',
            'developer'=>'Blizzard Entertainment',
        ]);

        Game::create([
            'name'=>'Diablo 3',
            'developer'=>'Blizzard Entertainment',
        ]);

        Game::create([
            'name'=>'Heroes of the Storm',
            'developer'=>'Blizzard Entertainment',
        ]);

        Game::create([
            'name'=>'Battlefield 1',
            'developer'=>'DICE',
            'publisher'=>'EA Games',
        ]);

        Game::create([
            'name'=>'Battlefield 4',
            'developer'=>'DICE',
            'publisher'=>'EA Games',
        ]);

        Game::create([
            'name'=>'The Sims 4',
            'developer'=>'Maxis',
            'publisher'=>'EA Games',
        ]);

        Game::create([
            'name'=>'The Sims 3',
            'developer'=>'Maxis',
            'publisher'=>'EA Games',
        ]);

        Game::create([
            'name'=>'Simcity',
            'developer'=>'Maxis',
            'publisher'=>'EA Games',
        ]);

    }
}
