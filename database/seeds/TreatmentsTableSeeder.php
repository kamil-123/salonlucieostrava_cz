<?php

use Illuminate\Database\Seeder;

class TreatmentsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('treatments')->truncate();
        
        \DB::table('treatments')->insert(array (
            0 => 
            array (
                'created_at' => NULL,
                'duration' => '01:00:00',
                'id' => 1,
                'name' => 'Cut, blow, wash and finish',
                'price' => 600,
                'stylist_id' => 1,
                'updated_at' => NULL,
            ),
            1 => 
            array (
                'created_at' => NULL,
                'duration' => '01:00:00',
                'id' => 2,
                'name' => 'Coloring',
                'price' => 700,
                'stylist_id' => 1,
                'updated_at' => NULL,
            ),
            2 => 
            array (
                'created_at' => NULL,
                'duration' => '01:30:00',
                'id' => 3,
                'name' => 'Elumen coloring',
                'price' => 800,
                'stylist_id' => 1,
                'updated_at' => NULL,
            ),
            3 => 
            array (
                'created_at' => NULL,
                'duration' => '01:00:00',
                'id' => 4,
                'name' => 'Highlights',
                'price' => 700,
                'stylist_id' => 1,
                'updated_at' => NULL,
            ),
            4 => 
            array (
                'created_at' => NULL,
                'duration' => '01:00:00',
                'id' => 5,
                'name' => 'Keratin',
                'price' => 1000,
                'stylist_id' => 1,
                'updated_at' => NULL,
            ),
            5 => 
            array (
                'created_at' => NULL,
                'duration' => '01:30:00',
                'id' => 6,
                'name' => 'Gala hairstyle',
                'price' => 600,
                'stylist_id' => 1,
                'updated_at' => NULL,
            ),
            6 => 
            array (
                'created_at' => NULL,
                'duration' => '02:00:00',
                'id' => 7,
                'name' => 'Wedding hairstyle',
                'price' => 1000,
                'stylist_id' => 1,
                'updated_at' => NULL,
            ),
            7 => 
            array (
                'created_at' => NULL,
                'duration' => '01:00:00',
                'id' => 8,
                'name' => 'Cut, blow, wash and finish',
                'price' => 600,
                'stylist_id' => 2,
                'updated_at' => NULL,
            ),
            8 => 
            array (
                'created_at' => NULL,
                'duration' => '01:00:00',
                'id' => 9,
                'name' => 'Coloring',
                'price' => 700,
                'stylist_id' => 2,
                'updated_at' => NULL,
            ),
            9 => 
            array (
                'created_at' => NULL,
                'duration' => '01:30:00',
                'id' => 10,
                'name' => 'Elumen coloring',
                'price' => 800,
                'stylist_id' => 2,
                'updated_at' => NULL,
            ),
            10 => 
            array (
                'created_at' => NULL,
                'duration' => '01:00:00',
                'id' => 11,
                'name' => 'Highlights',
                'price' => 700,
                'stylist_id' => 2,
                'updated_at' => NULL,
            ),
            11 => 
            array (
                'created_at' => NULL,
                'duration' => '01:00:00',
                'id' => 12,
                'name' => 'Keratin',
                'price' => 1000,
                'stylist_id' => 2,
                'updated_at' => NULL,
            ),
            12 => 
            array (
                'created_at' => NULL,
                'duration' => '01:30:00',
                'id' => 13,
                'name' => 'Gala hairstyle',
                'price' => 600,
                'stylist_id' => 2,
                'updated_at' => NULL,
            ),
            13 => 
            array (
                'created_at' => NULL,
                'duration' => '02:00:00',
                'id' => 14,
                'name' => 'Wedding hairstyle',
                'price' => 1000,
                'stylist_id' => 2,
                'updated_at' => NULL,
            ),
            14 => 
            array (
                'created_at' => NULL,
                'duration' => '00:30:00',
                'id' => 15,
                'name' => 'Classic cutting',
                'price' => 400,
                'stylist_id' => 3,
                'updated_at' => NULL,
            ),
            15 => 
            array (
                'created_at' => NULL,
                'duration' => '00:30:00',
                'id' => 16,
                'name' => 'Cutting long hair',
                'price' => 500,
                'stylist_id' => 3,
                'updated_at' => NULL,
            ),
            16 => 
            array (
                'created_at' => NULL,
                'duration' => '01:00:00',
                'id' => 17,
                'name' => 'Classic haircut and grooming',
                'price' => 550,
                'stylist_id' => 3,
                'updated_at' => NULL,
            ),
            17 => 
            array (
                'created_at' => NULL,
                'duration' => '00:30:00',
                'id' => 18,
                'name' => 'Cutting with a shaver',
                'price' => 300,
                'stylist_id' => 3,
                'updated_at' => NULL,
            ),
            18 => 
            array (
                'created_at' => NULL,
                'duration' => '01:00:00',
                'id' => 19,
                'name' => 'Hair colouring',
                'price' => 450,
                'stylist_id' => 3,
                'updated_at' => NULL,
            ),
            19 => 
            array (
                'created_at' => NULL,
                'duration' => '00:30:00',
                'id' => 20,
                'name' => 'Eyelash dyeing',
                'price' => 80,
                'stylist_id' => 4,
                'updated_at' => NULL,
            ),
            20 => 
            array (
                'created_at' => NULL,
                'duration' => '00:30:00',
                'id' => 21,
                'name' => 'Eyebrow coloring',
                'price' => 70,
                'stylist_id' => 4,
                'updated_at' => NULL,
            ),
            21 => 
            array (
                'created_at' => NULL,
                'duration' => '00:30:00',
                'id' => 22,
                'name' => 'Eyebrow Adjustment',
                'price' => 70,
                'stylist_id' => 4,
                'updated_at' => NULL,
            ),
            22 => 
            array (
                'created_at' => NULL,
                'duration' => '00:30:00',
                'id' => 23,
                'name' => 'Coloring + eyebrow adjustment',
                'price' => 120,
                'stylist_id' => 4,
                'updated_at' => NULL,
            ),
            23 => 
            array (
                'created_at' => NULL,
                'duration' => '00:30:00',
                'id' => 24,
                'name' => 'Depilation of upper lip with wax',
                'price' => 70,
                'stylist_id' => 4,
                'updated_at' => NULL,
            ),
            24 => 
            array (
                'created_at' => NULL,
                'duration' => '00:30:00',
                'id' => 25,
                'name' => 'Makeup Daily',
                'price' => 250,
                'stylist_id' => 4,
                'updated_at' => NULL,
            ),
            25 => 
            array (
                'created_at' => NULL,
                'duration' => '01:00:00',
                'id' => 26,
                'name' => 'Make-up Evening',
                'price' => 300,
                'stylist_id' => 4,
                'updated_at' => NULL,
            ),
            26 => 
            array (
                'created_at' => NULL,
                'duration' => '01:00:00',
                'id' => 27,
                'name' => 'Makeup Wedding',
                'price' => 500,
                'stylist_id' => 4,
                'updated_at' => NULL,
            ),
        ));
        
        
    }
}