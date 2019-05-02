<?php

use Illuminate\Database\Seeder;

class SessionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $clientA = factory(\App\Clients\Client::class)->create();
        $clientB = factory(\App\Clients\Client::class)->create();
        $clientC = factory(\App\Clients\Client::class)->create();

        $staffA = factory(\App\User::class)->create(['is_manager' => false]);
        $staffB = factory(\App\User::class)->create(['is_manager' => false]);
        $staffC = factory(\App\User::class)->create(['is_manager' => false]);

        factory(\App\Time\Session::class)->create([
            'user_id' => $staffA,
            'client_id' => $clientA,
            'start_time' => \Carbon\Carbon::today()->subDays(3)->setHour(8)->setMinutes(0),
            'end_time' => \Carbon\Carbon::today()->subDays(3)->setHour(10)->setMinutes(0),
        ]);

        factory(\App\Time\Session::class)->create([
            'user_id' => $staffA,
            'client_id' => $clientB,
            'start_time' => \Carbon\Carbon::today()->subDays(3)->setHour(10)->setMinutes(0),
            'end_time' => \Carbon\Carbon::today()->subDays(3)->setHour(12)->setMinutes(0),
        ]);

        factory(\App\Time\Session::class)->create([
            'user_id' => $staffA,
            'client_id' => $clientC,
            'start_time' => \Carbon\Carbon::today()->subDays(3)->setHour(14)->setMinutes(0),
            'end_time' => \Carbon\Carbon::today()->subDays(3)->setHour(16)->setMinutes(0),
        ]);

        factory(\App\Time\Session::class)->create([
            'user_id' => $staffB,
            'client_id' => $clientA,
            'start_time' => \Carbon\Carbon::today()->subDays(3)->setHour(8)->setMinutes(0),
            'end_time' => \Carbon\Carbon::today()->subDays(3)->setHour(10)->setMinutes(0),
        ]);

        factory(\App\Time\Session::class)->create([
            'user_id' => $staffB,
            'client_id' => $clientB,
            'start_time' => \Carbon\Carbon::today()->subDays(3)->setHour(10)->setMinutes(0),
            'end_time' => \Carbon\Carbon::today()->subDays(3)->setHour(12)->setMinutes(0),
        ]);

        factory(\App\Time\Session::class)->create([
            'user_id' => $staffB,
            'client_id' => $clientC,
            'start_time' => \Carbon\Carbon::today()->subDays(3)->setHour(14)->setMinutes(0),
            'end_time' => \Carbon\Carbon::today()->subDays(3)->setHour(16)->setMinutes(0),
        ]);

        factory(\App\Time\Session::class)->create([
            'user_id' => $staffC,
            'client_id' => $clientA,
            'start_time' => \Carbon\Carbon::today()->subDays(3)->setHour(8)->setMinutes(0),
            'end_time' => \Carbon\Carbon::today()->subDays(3)->setHour(10)->setMinutes(0),
        ]);

        factory(\App\Time\Session::class)->create([
            'user_id' => $staffC,
            'client_id' => $clientB,
            'start_time' => \Carbon\Carbon::today()->subDays(3)->setHour(10)->setMinutes(0),
            'end_time' => \Carbon\Carbon::today()->subDays(3)->setHour(12)->setMinutes(0),
        ]);

        factory(\App\Time\Session::class)->create([
            'user_id' => $staffC,
            'client_id' => $clientC,
            'start_time' => \Carbon\Carbon::today()->subDays(3)->setHour(14)->setMinutes(0),
            'end_time' => \Carbon\Carbon::today()->subDays(3)->setHour(16)->setMinutes(0),
        ]);

        //day 2
        factory(\App\Time\Session::class)->create([
            'user_id' => $staffA,
            'client_id' => $clientA,
            'start_time' => \Carbon\Carbon::today()->subDays(2)->setHour(8)->setMinutes(0),
            'end_time' => \Carbon\Carbon::today()->subDays(2)->setHour(10)->setMinutes(0),
        ]);

        factory(\App\Time\Session::class)->create([
            'user_id' => $staffA,
            'client_id' => $clientB,
            'start_time' => \Carbon\Carbon::today()->subDays(2)->setHour(10)->setMinutes(0),
            'end_time' => \Carbon\Carbon::today()->subDays(2)->setHour(12)->setMinutes(0),
        ]);

        factory(\App\Time\Session::class)->create([
            'user_id' => $staffA,
            'client_id' => $clientC,
            'start_time' => \Carbon\Carbon::today()->subDays(2)->setHour(14)->setMinutes(0),
            'end_time' => \Carbon\Carbon::today()->subDays(2)->setHour(16)->setMinutes(0),
        ]);

        factory(\App\Time\Session::class)->create([
            'user_id' => $staffB,
            'client_id' => $clientA,
            'start_time' => \Carbon\Carbon::today()->subDays(2)->setHour(8)->setMinutes(0),
            'end_time' => \Carbon\Carbon::today()->subDays(2)->setHour(10)->setMinutes(0),
        ]);

        factory(\App\Time\Session::class)->create([
            'user_id' => $staffB,
            'client_id' => $clientB,
            'start_time' => \Carbon\Carbon::today()->subDays(2)->setHour(10)->setMinutes(0),
            'end_time' => \Carbon\Carbon::today()->subDays(2)->setHour(12)->setMinutes(0),
        ]);

        factory(\App\Time\Session::class)->create([
            'user_id' => $staffB,
            'client_id' => $clientC,
            'start_time' => \Carbon\Carbon::today()->subDays(2)->setHour(14)->setMinutes(0),
            'end_time' => \Carbon\Carbon::today()->subDays(2)->setHour(16)->setMinutes(0),
        ]);

        factory(\App\Time\Session::class)->create([
            'user_id' => $staffC,
            'client_id' => $clientA,
            'start_time' => \Carbon\Carbon::today()->subDays(2)->setHour(8)->setMinutes(0),
            'end_time' => \Carbon\Carbon::today()->subDays(2)->setHour(10)->setMinutes(0),
        ]);

        factory(\App\Time\Session::class)->create([
            'user_id' => $staffC,
            'client_id' => $clientB,
            'start_time' => \Carbon\Carbon::today()->subDays(2)->setHour(10)->setMinutes(0),
            'end_time' => \Carbon\Carbon::today()->subDays(2)->setHour(12)->setMinutes(0),
        ]);

        factory(\App\Time\Session::class)->create([
            'user_id' => $staffC,
            'client_id' => $clientC,
            'start_time' => \Carbon\Carbon::today()->subDays(2)->setHour(14)->setMinutes(0),
            'end_time' => \Carbon\Carbon::today()->subDays(2)->setHour(16)->setMinutes(0),
        ]);

        //day 3
        factory(\App\Time\Session::class)->create([
            'user_id' => $staffA,
            'client_id' => $clientA,
            'start_time' => \Carbon\Carbon::today()->subDays(1)->setHour(8)->setMinutes(0),
            'end_time' => \Carbon\Carbon::today()->subDays(1)->setHour(10)->setMinutes(0),
        ]);

        factory(\App\Time\Session::class)->create([
            'user_id' => $staffA,
            'client_id' => $clientB,
            'start_time' => \Carbon\Carbon::today()->subDays(1)->setHour(10)->setMinutes(0),
            'end_time' => \Carbon\Carbon::today()->subDays(1)->setHour(12)->setMinutes(0),
        ]);

        factory(\App\Time\Session::class)->create([
            'user_id' => $staffA,
            'client_id' => $clientC,
            'start_time' => \Carbon\Carbon::today()->subDays(1)->setHour(14)->setMinutes(0),
            'end_time' => \Carbon\Carbon::today()->subDays(1)->setHour(16)->setMinutes(0),
        ]);

        factory(\App\Time\Session::class)->create([
            'user_id' => $staffB,
            'client_id' => $clientA,
            'start_time' => \Carbon\Carbon::today()->subDays(1)->setHour(8)->setMinutes(0),
            'end_time' => \Carbon\Carbon::today()->subDays(1)->setHour(10)->setMinutes(0),
        ]);

        factory(\App\Time\Session::class)->create([
            'user_id' => $staffB,
            'client_id' => $clientB,
            'start_time' => \Carbon\Carbon::today()->subDays(1)->setHour(10)->setMinutes(0),
            'end_time' => \Carbon\Carbon::today()->subDays(1)->setHour(12)->setMinutes(0),
        ]);

        factory(\App\Time\Session::class)->create([
            'user_id' => $staffB,
            'client_id' => $clientC,
            'start_time' => \Carbon\Carbon::today()->subDays(1)->setHour(14)->setMinutes(0),
            'end_time' => \Carbon\Carbon::today()->subDays(1)->setHour(16)->setMinutes(0),
        ]);

        factory(\App\Time\Session::class)->create([
            'user_id' => $staffC,
            'client_id' => $clientA,
            'start_time' => \Carbon\Carbon::today()->subDays(1)->setHour(8)->setMinutes(0),
            'end_time' => \Carbon\Carbon::today()->subDays(1)->setHour(10)->setMinutes(0),
        ]);

        factory(\App\Time\Session::class)->create([
            'user_id' => $staffC,
            'client_id' => $clientB,
            'start_time' => \Carbon\Carbon::today()->subDays(1)->setHour(10)->setMinutes(0),
            'end_time' => \Carbon\Carbon::today()->subDays(1)->setHour(12)->setMinutes(0),
        ]);

        factory(\App\Time\Session::class)->create([
            'user_id' => $staffC,
            'client_id' => $clientC,
            'start_time' => \Carbon\Carbon::today()->subDays(1)->setHour(14)->setMinutes(0),
            'end_time' => \Carbon\Carbon::today()->subDays(1)->setHour(16)->setMinutes(0),
        ]);


    }
}
