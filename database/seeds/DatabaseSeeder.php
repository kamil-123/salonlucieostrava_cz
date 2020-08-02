<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersTableSeeder::class);
        $this->call(StylistsTableSeeder::class);
        $this->call(TreatmentsTableSeeder::class);
        $this->call(CustomersTableSeeder::class);
        $this->call(BookingsTableSeeder::class);
    }
}
