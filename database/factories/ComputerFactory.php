<?php

use Trainner\Models\Group;
use Trainner\Models\User;
use Carbon\Carbon;
use Faker\Generator as Faker;

$factory->define(App\Models\Computer::class, function (Faker $faker) {

    $rand = rand(1, 100);
    $group = false;
    if ($rand<90){
        $group = Group::inRandomOrder()->first();
    }
    if (!$group) {
        $group = factory(Group::class)->create();
    }

    if (rand(0, 1) === 1) {
        return [
            'name' => $faker->name,
            'token' => $faker->uuid,
            'group_id' => $group->id,
            'is_active' => true
        ];
    }

    return [
        'token' => $faker->uuid,
        'is_active' => false,
    ];

});
