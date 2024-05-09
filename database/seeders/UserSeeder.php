<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $adminRoleId = Role::where('name', 'admin')->value('id');
        $userRoleId = Role::where('name', 'user')->value('id');


        User::factory()->create([
            'name' => 'Test User',
            'email' => 'admin@example.com',
            'password' => bcrypt('adminUser'),
            'role_id' => $adminRoleId,
            'description' => 'This is an admin user.',
        ]);

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'standardUser@example.com',
            'password' => bcrypt('standardUser'),
            'role_id' => $userRoleId,
            'description' => 'This is a standard user.',
        ]);
    }
}
