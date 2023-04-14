<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Permission::create(['name' => 'see users']);
        Permission::create(['name' => 'edit users']);
        Permission::create(['name' => 'see products']);
        Permission::create(['name' => 'create products']);
        Permission::create(['name' => 'edit products']);
        Permission::create(['name' => 'delete products']);
        Permission::create(['name' => 'edit shopping cart']);
        Permission::create(['name' => 'see payments']);
        Permission::create(['name' => 'approve payments']);
    }
}
