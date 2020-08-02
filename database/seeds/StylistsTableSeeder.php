<?php

use Illuminate\Database\Seeder;

class StylistsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('stylists')->truncate();
        
        \DB::table('stylists')->insert(array (
            0 => 
            array (
                'created_at' => NULL,
                'id' => 1,
                'introduction' => 'some introduction',
                'job_title' => 'Woman hair stylist',
                'profile_photo_url' => 'lucie.jpg',
                'service' => 'Woman hair style',
                'updated_at' => NULL,
                'user_id' => 1,
            ),
            1 => 
            array (
                'created_at' => NULL,
                'id' => 2,
                'introduction' => 'some introduction',
                'job_title' => 'Woman hair stylist',
                'profile_photo_url' => 'katerina.jpg',
                'service' => 'Woman hair style',
                'updated_at' => NULL,
                'user_id' => 2,
            ),
            2 => 
            array (
                'created_at' => NULL,
                'id' => 3,
                'introduction' => 'some introduction',
                'job_title' => 'Men hair stylist',
                'profile_photo_url' => 'vilma.jpg',
                'service' => 'Men hair style',
                'updated_at' => NULL,
                'user_id' => 3,
            ),
            3 => 
            array (
                'created_at' => NULL,
                'id' => 4,
                'introduction' => 'some introduction',
                'job_title' => 'aneta.jpg',
                'profile_photo_url' => 'aneta',
                'service' => 'Cosmetics',
                'updated_at' => NULL,
                'user_id' => 4,
            ),
        ));
        
        
    }
}