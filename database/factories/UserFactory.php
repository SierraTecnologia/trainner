<?php

use Trainner\Models\Role;
use Faker\Generator as Faker;

$factory->define(App\Models\User::class, function (Faker $faker) {
    $fakerBr = \Faker\Factory::create('pt_BR');
    return [
        'name' => $faker->name,
        'cpf' => preg_replace('/[^0-9]/', '', $fakerBr->cpf),
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
        'remember_token' => \Illuminate\Support\Str::random(10),
        'role_id' => Role::$CLIENT
    ];
});
