<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;

$factory->define(\Emotionally\Video::class, function (Faker $faker) {
    $duration = $faker->time('m:s');
    return [
        'name' => $faker->sentence(rand(1, 6)),
        'framerate' => $faker->numberBetween(1, 60),
        'start' => $faker->time('m:s', $duration),
        'end' => $faker->time('m:s', $duration),
        'duration' => $duration,
        'url' => $faker->imageUrl(),
        'report' => json_encode([]),
        'project_id' => factory(\Emotionally\Project::class)->create()->id,
        'user_id' => factory(\Emotionally\User::class)->create()->id,
    ];
});
