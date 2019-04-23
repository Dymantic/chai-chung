<?php

use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\User::class)->create([
            'email' => 'joe@example.com',
            'password' => Hash::make('password'),
            'is_manager' => false,
        ]);

        factory(\App\User::class)->create([
            'email' => 'joyner.michael@gmail.com',
            'password' => Hash::make('secret'),
            'is_manager' => true,
        ]);
    }
}
