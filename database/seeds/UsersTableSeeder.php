<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = [
            'name' => 'Ian Vital',
            'email' => '373357042@qq.com',
            'password' => bcrypt('password')
        ];
        \App\User::create($user);
    }
}
