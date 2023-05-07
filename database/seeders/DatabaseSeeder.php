<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Subcategory;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        /**
         * Commented this line to avoid to create users when use php artisan db:seed
         */
        // User::factory(1000)->create();

        Subcategory::factory(20)->create();
    }
}
