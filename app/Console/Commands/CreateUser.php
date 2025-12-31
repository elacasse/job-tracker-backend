<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateUser extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'user:create
                            {name? : The user\'s name}
                            {email? : The user\'s email}
                            {--password= : Optional password (otherwise asked interactively)}';

    /**
     * The console command description.
     */
    protected $description = 'Create a new user account';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $name = $this->argument('name') ?? $this->ask('Name');
        $email = $this->argument('email') ?? $this->ask('Email');

        // Check for existing user
        if (User::where('email', $email)->exists()) {
            $this->error("A user with email {$email} already exists.");
            return self::FAILURE;
        }

        // Password handling (option or interactive)
        $password = $this->option('password');

        if (!$password) {
            $password = $this->secret('Password');
            $confirm = $this->secret('Confirm Password');

            if ($password !== $confirm) {
                $this->error('Passwords do not match.');
                return self::FAILURE;
            }
        }

        // Create user
        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
        ]);

        $this->info("User created successfully:");
        $this->line("ID: {$user->id}");
        $this->line("Name: {$user->name}");
        $this->line("Email: {$user->email}");

        return self::SUCCESS;
    }
}
