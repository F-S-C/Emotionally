<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;

$factory->define(\Emotionally\Project::class, function (Faker $faker) {
    return [
        'name' => $faker->sentence(rand(1, 3)),
        'father_id' => factory(\Emotionally\Project::class)->create()->id,
        'user_id'=>factory(\Emotionally\User::class)->create()->id,
    ];
});
