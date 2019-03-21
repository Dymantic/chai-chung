<?php

use Faker\Generator as Faker;

$factory->define(\App\Clients\EngagementCode::class, function (Faker $faker) {
    return [
        'code' => \Illuminate\Support\Str::random(6),
        'description' => $faker->sentence
    ];
});
