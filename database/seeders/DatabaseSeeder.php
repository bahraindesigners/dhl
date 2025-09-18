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
        // Seed permissions and roles first
        $this->call(PermissionSeeder::class);

        // Seed users
        $this->call(UserSeeder::class);

        // Seed blog categories
        $this->call(BlogCategorySeeder::class);

        // Seed blog data
        $this->call(BlogSeeder::class);

        // Seed event data
        $this->call(EventSeeder::class);

        // Seed event registrations
        $this->call(EventRegistrationSeeder::class);

        // Seed home sliders
        $this->call(HomeSliderSeeder::class);
    }
}
