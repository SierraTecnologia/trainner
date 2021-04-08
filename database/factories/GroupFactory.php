<?php

use Faker\Generator as Faker;

use Trainner\Models\Playlist;
use Trainner\Models\Group;

$factory->define(Group::class, function (Faker $faker) {
    $rand = rand(1, 100);
    $playlist = false;
    if ($rand<90){
        $playlist = Playlist::inRandomOrder()->first();
    }
    if (!$playlist) {
        $playlist = factory(Playlist::class)->create();
    }

    return [
        'name' => $faker->company,
        'playlist_id' => $playlist->id,
        // 'status' => 1
    ];
});