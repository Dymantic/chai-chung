<?php

use Faker\Generator as Faker;

$factory->define(\App\Leave\LeaveRequest::class, function (Faker $faker) {
    return [
        'user_id' => function() {
            return factory(\App\User::class)->create()->id;
        },
        'covering_user_id' => function() {
            return factory(\App\User::class)->create()->id;
        },
        'starts' => \Illuminate\Support\Carbon::parse('next monday')->setHour(8)->setMinutes(0),
        'ends' => \Illuminate\Support\Carbon::parse('next monday')->setHour(17)->setMinutes(0),
        'reason' => $faker->sentence,
        'status' => 'submitted'
    ];
});
