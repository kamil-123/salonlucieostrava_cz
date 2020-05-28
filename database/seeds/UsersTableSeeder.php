<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('users')->truncate();
        
        \DB::table('users')->insert(array (
            0 => 
            array (
                'created_at' => '2020-03-22 20:52:59',
                'email' => 'l.barankova@seznam.cz',
                'email_verified_at' => NULL,
                'first_name' => 'Lucie',
                'id' => 1,
                'last_name' => 'Barankova',
                'password' => '$2y$10$/5CobUIPLAu2kFJBYxmw5.LX64GqCxVFgZ9zM1SKkeSr5/7Z6J7iG',
                'phone' => '606243030',
                'remember_token' => NULL,
                'role' => 1,
                'updated_at' => '2020-03-22 20:52:59',
            ),
            1 => 
            array (
                'created_at' => '2020-03-22 21:42:13',
                'email' => 'k.stanislavova@seznam.cz',
                'email_verified_at' => NULL,
                'first_name' => 'Katerina',
                'id' => 2,
                'last_name' => 'Stanislavova',
                'password' => '$2y$10$9pseu.X/GyVf7QbhI8ZNb.AglC49kiZ91NqWgNnPl1QHA9OpXTs.y',
                'phone' => '739210694',
                'remember_token' => NULL,
                'role' => 2,
                'updated_at' => '2020-03-22 21:42:13',
            ),
            2 => 
            array (
                'created_at' => '2020-03-22 21:44:07',
                'email' => 'v.szabova@seznam.cz',
                'email_verified_at' => NULL,
                'first_name' => 'Vilma',
                'id' => 3,
                'last_name' => 'Szabova',
                'password' => '$2y$10$FMb3Jm/eW.jrg7VMeTdmHuZ7uRbkUQFr4Ept5R/RosA7P/UtSs7l6',
                'phone' => '604705649',
                'remember_token' => NULL,
                'role' => 2,
                'updated_at' => '2020-03-22 21:44:07',
            ),
            3 => 
            array (
                'created_at' => '2020-03-22 21:46:30',
                'email' => 'a.cechova@seznam.cz',
                'email_verified_at' => NULL,
                'first_name' => 'Aneta',
                'id' => 4,
                'last_name' => 'Cechova',
                'password' => '$2y$10$rEIlynqrUSj2Ol9LhEdVq.DIp9gnG3M9CEaQzNsgP4ZJ8PrHjBSJe',
                'phone' => '777718918',
                'remember_token' => NULL,
                'role' => 2,
                'updated_at' => '2020-03-22 21:46:30',
            ),
        ));
        
        
    }
}