<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Emotionally\Project;
use Emotionally\User;
use Emotionally\Video;
use Faker\Generator as Faker;

$factory->define(Video::class, function (Faker $faker) {
    $duration = $faker->time('m:s');

    $report = [];
    $basic_report = [
        "joy" => 0,
        "sadness" => 0,
        "disgust" => 0,
        "contempt" => 0,
        "anger" => 0,
        "fear" => 0,
        "surprise" => 0,
        "valence" => 0,
        "engagement" => 0,
        "Timestamp" => 0,
        "smile" => 0,
        "innerBrowRaise" => 0,
        "browRaise" => 0,
        "browFurrow" => 0,
        "noseWrinkle" => 0,
        "upperLipRaise" => 0,
        "lipCornerDepressor" => 0,
        "chinRaise" => 0,
        "lipPucker" => 0,
        "lipPress" => 0,
        "lipSuck" => 0,
        "mouthOpen" => 0,
        "smirk" => 0,
        "eyeClosure" => 0,
        "attention" => 0,
        "lidTighten" => 0,
        "jawDrop" => 0,
        "dimpler" => 0,
        "eyeWiden" => 0,
        "cheekRaise" => 0,
        "lipStretch" => 0
    ];
    for ($i = 0; $i < rand(50, 150); $i++) {
        foreach ($basic_report as &$value) {
            $value = $faker->randomFloat(20, 0, 1);
        }
        array_push($report, $basic_report);
    }

    return [
        'name' => $faker->sentence(rand(1, 4)),
        'framerate' => $faker->numberBetween(1, 60),
        'start' => $faker->time('m:s', $duration),
        'end' => $faker->time('m:s', $duration),
        'duration' => $duration,
        'url' => $faker->imageUrl(),
        // A JSON report previously generated
        'report' => json_encode($report),
        'project_id' => factory(Project::class)->create()->id,
        'user_id' => factory(User::class)->create()->id,
    ];
});
