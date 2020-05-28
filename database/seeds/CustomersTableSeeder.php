<?php

use Illuminate\Database\Seeder;

class CustomersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('customers')->truncate();
        
        \DB::table('customers')->insert(array (
            0 => 
            array (
                'created_at' => NULL,
                'email' => 'p.vomackova@seznam.cz',
                'first_name' => 'Petra',
                'id' => 1,
                'last_name' => 'Vomackova',
                'phone' => '777123456',
                'updated_at' => NULL,
                'user_id' => NULL,
            ),
            1 => 
            array (
                'created_at' => NULL,
                'email' => 'bibca@seznam.cz',
                'first_name' => 'Miroslava',
                'id' => 2,
                'last_name' => 'Drozdova',
                'phone' => '777654321',
                'updated_at' => NULL,
                'user_id' => NULL,
            ),
            2 => 
            array (
                'created_at' => NULL,
                'email' => 'miroslav.drozd@icloud.com',
                'first_name' => 'Miroslav',
                'id' => 3,
                'last_name' => 'Drozd',
                'phone' => '602365412',
                'updated_at' => NULL,
                'user_id' => NULL,
            ),
            3 => 
            array (
                'created_at' => NULL,
                'email' => 'dagmar.barankova@email.cz',
                'first_name' => 'Dagmar',
                'id' => 4,
                'last_name' => 'Barankova',
                'phone' => '775123456',
                'updated_at' => NULL,
                'user_id' => NULL,
            ),
            4 => 
            array (
                'created_at' => NULL,
                'email' => 'o.baranek@seznam.cz',
                'first_name' => 'Ondrej',
                'id' => 5,
                'last_name' => 'Baranek',
                'phone' => '776123456',
                'updated_at' => NULL,
                'user_id' => NULL,
            ),
            5 => 
            array (
                'created_at' => NULL,
                'email' => 'eliska.drozdova@icloud.com',
                'first_name' => 'Eliska',
                'id' => 6,
                'last_name' => 'Drozdova',
                'phone' => '777310075',
                'updated_at' => NULL,
                'user_id' => NULL,
            ),
            6 => 
            array (
                'created_at' => NULL,
                'email' => 'd.mulerova@seznam.cz',
                'first_name' => 'Dita',
                'id' => 7,
                'last_name' => 'Mulerova',
                'phone' => '605123456',
                'updated_at' => NULL,
                'user_id' => NULL,
            ),
            7 => 
            array (
                'created_at' => NULL,
                'email' => 'blanka.tesa@seznam.cz',
                'first_name' => 'Blanka',
                'id' => 8,
                'last_name' => 'Tesarova',
                'phone' => '606123456',
                'updated_at' => NULL,
                'user_id' => NULL,
            ),
            8 => 
            array (
                'created_at' => NULL,
                'email' => 'milan.tesar@seznam.cz',
                'first_name' => 'Milan',
                'id' => 9,
                'last_name' => 'Tesar',
                'phone' => '603123456',
                'updated_at' => NULL,
                'user_id' => NULL,
            ),
            9 => 
            array (
                'created_at' => NULL,
                'email' => 'petr.vosecky@email.cz',
                'first_name' => 'Petr',
                'id' => 10,
                'last_name' => 'Vosecky',
                'phone' => '603654321',
                'updated_at' => NULL,
                'user_id' => NULL,
            ),
            10 => 
            array (
                'created_at' => NULL,
                'email' => 'monika.vosecka@email.cz',
                'first_name' => 'Monika',
                'id' => 11,
                'last_name' => 'Vosecka',
                'phone' => '601231456',
                'updated_at' => NULL,
                'user_id' => NULL,
            ),
            11 => 
            array (
                'created_at' => NULL,
                'email' => 'eva.bugalova@twsa.cz',
                'first_name' => 'Eva',
                'id' => 12,
                'last_name' => 'Bugalova',
                'phone' => '602456123',
                'updated_at' => NULL,
                'user_id' => NULL,
            ),
            12 => 
            array (
                'created_at' => NULL,
                'email' => 'petra.dvorakova@twsa.cz',
                'first_name' => 'Petra',
                'id' => 13,
                'last_name' => 'Dvorakova',
                'phone' => '602321654',
                'updated_at' => NULL,
                'user_id' => NULL,
            ),
            13 => 
            array (
                'created_at' => NULL,
                'email' => 'andrea.barglova@tawesco.cz',
                'first_name' => 'Andrea',
                'id' => 14,
                'last_name' => 'Barglova',
                'phone' => '603456123',
                'updated_at' => NULL,
                'user_id' => NULL,
            ),
            14 => 
            array (
                'created_at' => NULL,
                'email' => 'a.osawa1002@gmail.com',
                'first_name' => 'Ayumi',
                'id' => 15,
                'last_name' => 'Osawa',
                'phone' => '604456123',
                'updated_at' => NULL,
                'user_id' => NULL,
            ),
            15 => 
            array (
                'created_at' => NULL,
                'email' => 'brunokozina24@gmail.com',
                'first_name' => 'Bruno',
                'id' => 16,
                'last_name' => 'Kozina',
                'phone' => '608123456',
                'updated_at' => NULL,
                'user_id' => NULL,
            ),
        ));
        
        
    }
}