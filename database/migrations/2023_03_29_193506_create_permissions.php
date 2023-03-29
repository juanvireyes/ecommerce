<?php

use Spatie\Permission\Models\Permission;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
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

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Permission::where('name', 'see users')->delete();
        Permission::where('name', 'edit users')->delete();
        Permission::where('name', 'see products')->delete();
        Permission::where('name', 'create products')->delete();
        Permission::where('name', 'edit products')->delete();
        Permission::where('name', 'delete products')->delete();
        Permission::where('name', 'edit shopping cart')->delete();
        Permission::where('name', 'see payments')->delete();
        Permission::where('name', 'approve payments')->delete();
    }
};
