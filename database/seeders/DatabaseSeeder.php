<?php

namespace Database\Seeders;

use App\Models\Application;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Application::create([
            'name' => 'Postman',
            'token_hash' => Hash::make(env('SEED_ADMIN_APP_TOKEN_POSTMAN')),
        ]);

        Application::create([
            'name' => 'job-tracker.test',
            'token_hash' => Hash::make(env('SEED_ADMIN_APP_TOKEN_FRONTEND')),
        ]);

        User::factory()->create([
            'name' => env('SEED_ADMIN_NAME'),
            'email' => env('SEED_ADMIN_EMAIL'),
            'password' => Hash::make(env('SEED_ADMIN_PASSWORD')),
        ]);
    }
}
