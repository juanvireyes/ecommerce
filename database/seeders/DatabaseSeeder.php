<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use App\Models\Product;
use App\Models\Subcategory;
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

        /**
         * Commented this line to avoid to create subcategories when use php artisan db:seed
         */
        // Subcategory::factory(20)->create();

        Product::factory(40)->create();
    }
}
