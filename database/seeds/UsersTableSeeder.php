<?php

use App\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
           'firstname'=>'test',
           'lastname'=>'man',
            'email'=>'test@test.com',
            'password'=>bcrypt('TestTestTest'),
            'birthdate'=>'1995-04-21',
            'gender'=>'MALE',
            'profile_id' => 1

        ]);

        factory(App\User::class, 19)->create();
    }
}
