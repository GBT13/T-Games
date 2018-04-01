<?php

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\User::class, function (Faker $faker) {
    return [
        'firstname' => $faker->firstName,
        'lastname' => $faker->lastName,
        'email' => $faker->unique()->safeEmail,
        'password' => '$2y$10$dtx2rgN3czE07fC2l9YOV.JzZpmwsNlfuxaR/7f2dsDA90rrbSKh6', // secret
        'birthdate' => $faker->date(),
        'gender' => $faker->randomElement(['MALE', 'FEMALE']),
        'remember_token' => str_random(10),
    ];
});
