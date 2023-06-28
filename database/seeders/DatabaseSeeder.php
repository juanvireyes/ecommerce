<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Category;
use App\Models\User;
use App\Models\Product;
use App\Models\Subcategory;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            User::factory(1000)->create(),
            Category::factory(5)->create(),
            Subcategory::factory(20)->create(),
            Product::factory(40)->create()
        ]);
    }
}
