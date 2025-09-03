<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed users
        $this->call(UserSeeder::class);

        // Seed blog data
        $this->call(BlogSeeder::class);

        // Seed event data
        $this->call(EventSeeder::class);
    }
}
