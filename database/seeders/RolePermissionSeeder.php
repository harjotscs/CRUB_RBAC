<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    public function run()
    {
        $adminRole = Role::findByName('admin');
        $adminRole->givePermissionTo('create_user');
        $adminRole->givePermissionTo('read_user');
        $adminRole->givePermissionTo('read_users');
        $adminRole->givePermissionTo('update_user');
        $adminRole->givePermissionTo('delete_user');

        $userRole = Role::findByName('user');
        $userRole->givePermissionTo('read_user');
    }
}