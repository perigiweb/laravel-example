<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@perigi.my.id',
            'password' => '123456qwerty',
            'is_admin' => true,
            'is_active' => true,
        ]);
        User::factory()->create([
            'name' => 'User',
            'email' => 'user@perigi.my.id',
            'password' => '123456qwerty',
            'is_admin' => false,
            'is_active' => true,
        ]);
    }
}
