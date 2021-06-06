<?php

use Faker\Generator as Faker;

use Trainner\Models\Playlist;

$factory->define(Playlist::class, function (Faker $faker) {
    return [
        'name' => $faker->jobTitle,
        'status' => 1
    ];
});