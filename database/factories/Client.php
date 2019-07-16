<?php

use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(\App\Clients\Client::class, function (Faker $faker) {
    return [
        'name' => $faker->company,
        'client_code' => Str::random(6),
        'annual_revenue' => 1000000,
        'pastured_on' => null,
    ];
});
