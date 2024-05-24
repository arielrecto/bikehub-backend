<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'USER_1 Throw User',
            'email' => 'throw01@email.com',
        ]);

        User::factory()->create([
            'name' => 'USER_2 Throw User',
            'email' => 'throw02@email.com',
        ]);

        User::factory()->create([
            'name' => 'ADMIN_1 Admin User',
            'email' => 'admin1@email.com',
        ]);
    }
}
