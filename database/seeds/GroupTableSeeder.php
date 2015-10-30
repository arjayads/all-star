<?php

use Illuminate\Database\Seeder;

class GroupTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('groups')->insert([
            [
                'name'       => 'Admin',
                'default_url'   => '/admin'
            ],
            [
                'name'       => 'Member',
                'default_url'   => '/profile'
            ]
        ]);
    }
}
