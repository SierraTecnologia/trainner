<?php

use Faker\Generator as Faker;
use Trainner\Models\Video;

$factory->define(App\Models\Video::class, function (Faker $faker) {

    $mediaService = new \App\Services\MediaService();
    $files = $mediaService->allFiles();
    $randomFile = array_rand($files, 1);

    return [
        'name' => $files[$randomFile]['name'],
        'url' => $files[$randomFile]['path'],
        'path' => $files[$randomFile]['relative_path'],
        'type' => $files[$randomFile]['type'],
        'filename' => $files[$randomFile]['filename'],
        'size' => $files[$randomFile]['size'],
        'last_modified' => $files[$randomFile]['last_modified'],
    ];
});