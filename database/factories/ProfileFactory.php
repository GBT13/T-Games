<?php

use Faker\Generator as Faker;

$factory->define(App\Profile::class, function (Faker $faker) {
    return [
        'bio' => $faker->realText(500),
        'steamid' => 'https://steamcommunity.com/id/' . $faker->ean8,
        'psnName' => $faker->userName,
        'xboxGamertag' => $faker->userName,
        'originName' => $faker->userName,
        'uplayName' => $faker->userName,
        'battletag' => $faker->userName,
        'discord' => $faker->userName,
        'epicName' => $faker->userName,
        'nintendoNetworkId'=>$faker->userName,
        'user_id' => 2
    ];
});
