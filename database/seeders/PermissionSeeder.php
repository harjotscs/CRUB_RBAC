<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    public function run()
    {
        Permission::create(['name' => 'create_user']);
        Permission::create(['name' => 'read_users']);
        Permission::create(['name' => 'read_user']);
        Permission::create(['name' => 'delete_user']);
        Permission::create(['name' => 'update_user']);
    }
}
