<?php

use Faker\Generator as Faker;

$factory->define(App\Profile::class, function (Faker $faker) {
    return [
        'bioText' => $faker->realText(500),
        'steamname' => 'https://steamcommunity.com/id/' . $faker->ean8,
        'playstationname' => $faker->userName,
        'xboxname' => $faker->userName,
        'discordname' => $faker->userName,
        'epicname' => $faker->userName,
        'nintendoname' => $faker->userName,
        'eaname' => $faker->userName,
        'uplayname' => $faker->userName,
        'blizzardname'=>$faker->userName
    ];
});
