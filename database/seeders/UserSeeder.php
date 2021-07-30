<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //admin account
        DB::table('users')->insert([
            'name' => "Admin",
            'email' => 'a@b.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
            'lastlogin_at' => now(),
            'current_team_id' => 3,
            'timezone' => 'America/New_York'
        ]);
    }
}
