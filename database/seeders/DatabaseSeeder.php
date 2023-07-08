<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Category;
use App\Models\User;
use App\Models\Product;
use App\Models\Subcategory;
use Illuminate\Database\Seeder;
use Spatie\Permission\Contracts\Permission;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            PermissionsSeeder::class,
            RolesSeeder::class,
            User::factory(1000)->create(),
            Category::factory(5)->create(),
            Subcategory::factory(20)->create(),
            Product::factory(100)->create()
        ]);
    }
}
