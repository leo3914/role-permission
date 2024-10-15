<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        User::create([
            'name' => "Admin PPK",
            'email' => "admin@gmail.com",
            'phone' => "123123123",
            'password' => Hash::make("admin1234"),
            'role_id' => 1
        ]);
        Role::create([
            'role' => "Admin"
        ]);
        $permissions = ["user-create", "user-read", "user-update", "user-delete"];
        foreach ($permissions as $per) {
            Permission::create([
                'name' => $per,
            ]);
        };
    }
}
