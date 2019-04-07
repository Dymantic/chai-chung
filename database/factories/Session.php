<?php

use Faker\Generator as Faker;

$factory->define(\App\Time\Session::class, function (Faker $faker) {
    return [
        'user_id' => function() { return factory(\App\User::class)->create(); },
        'client_id' => function() { return factory(\App\Clients\Client::class)->create(); },
        'engagement_code_id' => function() { return factory(\App\Clients\EngagementCode::class)->create(); },
        'start_time' => \Illuminate\Support\Carbon::now()->subDays(3)->setHours(8)->setMinutes(30),
        'end_time' => \Illuminate\Support\Carbon::now()->subDays(3)->setHours(10)->setMinutes(30),
        'service_period' => '2019',
        'description' => $faker->sentence,
        'notes' => $faker->sentence
    ];
});
