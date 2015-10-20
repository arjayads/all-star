<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'name'    => 'john doe',
                'email'    => 'johndoe@tangkits.com',
                'avatar'   => 'https://avatars.githubusercontent.com/u/1678728?v=3',
                'social_id' => rand(1000, 10000),
                'provider' => 'github',
                'password' => Hash::make('default')
            ],
            [
                'name'    => 'john lennon',
                'email'    => 'johnlennon@tangkits.com',
                'avatar'   => 'https://avatars.githubusercontent.com/u/1678728?v=3',
                'social_id' => rand(1000, 10000),
                'provider' => 'github',
                'password' => Hash::make('default')
            ],
            [
                'name'    => 'john hughs',
                'email'    => 'johnhughs@tangkits.com',
                'avatar'   => 'https://avatars.githubusercontent.com/u/1678728?v=3',
                'social_id' => rand(1000, 10000),
                'provider' => 'github',
                'password' => Hash::make('default')
            ],
            [
                'name'    => 'john box',
                'email'    => 'johnbox@tangkits.com',
                'avatar'   => 'https://avatars.githubusercontent.com/u/1678728?v=3',
                'social_id' => rand(1000, 10000),
                'provider' => 'github',
                'password' => Hash::make('default')
            ],
            [
                'name'    => 'john lommis',
                'email'    => 'johnlommis@tangkits.com',
                'avatar'   => 'https://avatars.githubusercontent.com/u/1678728?v=3',
                'social_id' => rand(1000, 10000),
                'provider' => 'github',
                'password' => Hash::make('default')
            ],
        ]);
    }
}
