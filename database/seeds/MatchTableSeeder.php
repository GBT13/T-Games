<?php

use App\Match;
use Illuminate\Database\Seeder;

class MatchTableSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        Match::create([
            'profile_id' => 1,
            'partner_profile_id' => 2,
            'accepted' => false,
            'rejected' => false
        ]);

        Match::create([
            'profile_id' => 2,
            'partner_profile_id' => 1,
            'accepted' => true,
            'rejected' => false
        ]);

        Match::create([
            'profile_id' => 1,
            'partner_profile_id' => 3,
            'accepted' => true,
            'rejected' => false
        ]);

        Match::create([
            'profile_id' => 3,
            'partner_profile_id' => 1,
            'accepted' => true,
            'rejected' => false
        ]);

        Match::create([
            'profile_id' => 1,
            'partner_profile_id' => 4,
            'accepted' => false,
            'rejected' => false
        ]);

        Match::create([
            'profile_id' => 4,
            'partner_profile_id' => 1,
            'accepted' => true,
            'rejected' => false
        ]);
    }
}
