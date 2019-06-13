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
            'email' => 'manager@example.com',
            'password' => Hash::make('secret'),
            'is_manager' => true,
        ]);
    }
}
