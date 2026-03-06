<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $users = User::factory(80)->create();

        $users[] = User::factory()->create([
            'name' => 'Test User',
            'surname' => 'Test User',
            'login' => 'testuser',
            'email' => 'test@example.com',
        ]);
    }
}
