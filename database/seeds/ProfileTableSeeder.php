<?php

use App\Profile;
use Illuminate\Database\Seeder;

class ProfileTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Profile::create([
            'bioText'=>'Random bio bla bla leuke lange bio hiero top top top great great great',
            'steamname' => 'https://steamcommunity.com/id/Testman',
            'playstationname' => 'Testpsn',
            'xboxname' => 'TestXbox',
            'discordname' => 'testdiscord',
            'nintendoname' => 'testnintendo',
            'eaname' => 'testorigin',
            'blizzardname'=> 'testblizzard'
        ]);

        factory(App\Profile::class, 19)->create();
    }
}
