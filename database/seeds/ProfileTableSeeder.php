<?php

use App\Game;
use App\Profile;
use Illuminate\Database\Seeder;

class ProfileTableSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        Profile::create([
            'bio' => 'Random bio bla bla leuke lange bio hiero top top top great great great',
            'steamid' => 'https://steamcommunity.com/id/Testman',
            'psnName' => 'Testpsn',
            'xboxGamertag' => 'TestXbox',
            'discord' => 'testdiscord',
            'nintendoNetworkId' => 'testnintendo',
            'originName' => 'testorigin',
            'battletag' => 'testblizzard',
            'user_id' => 1
        ]);

        Profile::create([
            'bio' => '',
            'imageLocation' => '/images/sj.bmp',
            'steamid' => 'https://steamcommunity.com/id/blackwid0w',
            'psnName' => 'Sc4rLett',
            'discord' => 'SJohansson',
            'nintendoNetworkId' => 'Scarlett',
            'battletag' => 'ScarJo#0451',
            'user_id' => 2
        ]);

        Profile::create([
            'bio' => 'Ik ben Martijn hallo! Mijn favoriete bezigheid is programmeren in een combinatie van laravel en vue.',
            'imageLocation' => '/images/steen.bmp',
            'steamid' => 'https://steamcommunity.com/profiles/76561198060100470/',
            'discord' => 'Slay a Stone',
            'battletag' => 'steen#2649',
            'epicName' => 'Slay a Stone',
            'user_id' => 3
        ]);

        Profile::create([
            'bio' => 'Ik ben Raymon hallo! Mijn favoriete bezigheid is Pokémon Go spelen zodat ik niet hoef te vuen',
            'imageLocation' => '/images/raymon.bmp',
            'steamid' => 'http://steamcommunity.com/profiles/7656119811',
            'discord' => 'Rhezios',
            'battletag' => 'Rhezios#1657',
            'epicName' => 'Rhezios',
            'user_id' => 4
        ]);

        factory(App\Profile::class, 250)->create()->each(function ($profile) {
            $profile->user_id = $profile->id;
            $profile->update();
        });

        $games = App\Game::all();

//        My Games
        Profile::find(1)->games()->attach([
            Game::whereName('Factorio')->first()->id,
            Game::whereName('Starcraft 2')->first()->id,
            Game::whereName('Fortnite')->first()->id,
            Game::whereName('Stellaris')->first()->id,
            Game::whereName('Counter-Strike: Global Offensive')->first()->id,
            Game::whereName('Battlefield 4')->first()->id,
            Game::whereName('Team Fortress 2')->first()->id,
            Game::whereName('Left 4 Dead 2')->first()->id,
            Game::whereName('Battlefield 1')->first()->id,
            Game::whereName('PAYDAY 2')->first()->id,
            Game::whereName('Terraria')->first()->id,
            Game::whereName('Rocket League')->first()->id,
            Game::whereName('Half-Life 2')->first()->id,
            Game::whereName('Killing Floor 2')->first()->id,
        ]);

//        SJ's Games
        Profile::find(2)->games()->attach([
           Game::whereName('Factorio')->first()->id,
           Game::whereName('Stellaris')->first()->id,
           Game::whereName('Killing Floor 2')->first()->id,
        ]);

//        Martijn's Games
        Profile::find(3)->games()->attach([
            Game::whereName('Starcraft 2')->first()->id,
            Game::whereName('Fortnite')->first()->id,
            Game::whereName('Killing Floor 2')->first()->id,
            Game::whereName('Factorio')->first()->id,
            Game::whereName('PLAYERUNKNOWN\'S BATTLEGROUNDS')->first()->id,
            Game::whereName('Overwatch')->first()->id,
            Game::whereName('League of Legends')->first()->id,
        ]);

//        Raymon's Games
        Profile::find(4)->games()->attach([
            Game::whereName('League of Legends')->first()->id,
            Game::whereName('Rocket League')->first()->id,
            Game::whereName('Fortnite')->first()->id,
            Game::whereName('F1 2015')->first()->id,
        ]);


//        Seed selected games for profiles
        App\Profile::all()->each(function ($profile) use ($games) {
            $profile->games()->attach(
                $games->random(rand(5, 25))->pluck('id')->toArray()
            );

            if (rand(0, 2) == 1) {
                if (!$profile->games()->get()->contains('name', 'Counter-Strike: Global Offensive')) {
                    $profile->games()->attach(Game::whereName('Counter-Strike: Global Offensive')->first()->id);
                }

            } elseif (rand(0, 2) == 1) {
                if (!$profile->games()->get()->contains('name', 'Team Fortress 2')) {
                    $profile->games()->attach(Game::whereName('Team Fortress 2')->first()->id);
                }
            } elseif (rand(0, 4) == 3) {
                if (!$profile->games()->get()->contains('name', 'Battlefield 1')) {
                    $profile->games()->attach(Game::whereName('Battlefield 1')->first()->id);
                }
            } elseif (rand(0, 4) == 3) {
                if (!$profile->games()->get()->contains('name', 'Stellaris')) {
                    $profile->games()->attach(Game::whereName('Stellaris')->first()->id);
                }
            } elseif (rand(0, 4) == 3) {
                if (!$profile->games()->get()->contains('name', 'Factorio')) {
                    $profile->games()->attach(Game::whereName('Factorio')->first()->id);
                }
            }
        });

    }
}
