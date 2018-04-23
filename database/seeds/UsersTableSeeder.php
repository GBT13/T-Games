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
           'firstname'=>'Henk',
           'lastname'=>'van Overbeek',
            'email'=>'testman3@hotmail.com',
            'password'=>bcrypt('TestTestTest'),
            'birthdate'=>'1995-04-21',
            'gender'=>'MALE',

        ]);

        User::create([
           'firstname'=> 'Scarlett',
           'lastname' => 'Johansson',
            'email'=> 'johansson.scarlett@hollywood.com',
            'password'=>bcrypt('secret'),
            'birthdate'=>'1984-11-22',
            'gender' => 'FEMALE'
        ]);

        User::create([
           'firstname'=>'Martijn',
           'lastname'=>'van Adrichem',
           'email'=>'martijn@martijnvanadrichem.nl',
           'password'=>bcrypt('Martijn123!'),
           'birthdate'=>'1999-03-1',
           'gender'=>'MALE'
        ]);

        User::create([
            'firstname'=>'Raymon',
            'lastname'=>'Haalebos',
            'email'=>'raymonhaalebos@gmail.com',
            'password'=>bcrypt('Raymon123!'),
            'birthdate'=>'1999-02-19',
            'gender'=>'MALE'
        ]);

        factory(App\User::class, 250)->create();
    }
}
