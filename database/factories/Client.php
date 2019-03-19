<?php

use Faker\Generator as Faker;

$factory->define(\App\Clients\Client::class, function (Faker $faker) {
    return [
        'name' => $faker->company,
        'client_code' => 'test_' . $faker->numberBetween(100, 999),
        'annual_revenue' => 1000000
    ];
});
