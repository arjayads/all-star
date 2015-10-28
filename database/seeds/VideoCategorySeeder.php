<?php

use Illuminate\Database\Seeder;

class VideoCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('video_categories')->insert([
            [
                'name'    => 'Funny'
            ],
            [
                'name'    => 'Sad'
            ],
            [
                'name'    => 'Happy'
            ],
            [
                'name'    => 'Lonely'
            ],
            [
                'name'    => 'Exciting'
            ],
        ]);
    }
}
