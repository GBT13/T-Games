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
            'bio'=>'Random bio bla bla leuke lange bio hiero top top top great great great',
            'steamid' => 'https://steamcommunity.com/id/Testman',
            'psnName' => 'Testpsn',
            'xboxGamertag' => 'TestXbox',
            'discord' => 'testdiscord',
            'nintendoNetworkId' => 'testnintendo',
            'originName' => 'testorigin',
            'battletag'=> 'testblizzard'
        ]);

        factory(App\Profile::class, 19)->create();
    }
}
