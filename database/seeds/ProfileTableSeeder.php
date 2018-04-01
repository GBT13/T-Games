<?php

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

        factory(App\Profile::class, 49)->create()->each(function ($profile) {
            $profile->user_id = $profile->id;
            $profile->update();
        });

        $games = App\Game::all();

//        Seed selected games for profiles
        App\Profile::all()->each(function ($profile) use ($games) {
            $profile->games()->attach(
                $games->random(rand(0, 8))->pluck('id')->toArray()
            );
        });

    }
}
