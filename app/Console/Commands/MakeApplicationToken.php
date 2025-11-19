<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Application;
use Random\RandomException;
use Symfony\Component\Console\Command\Command as BaseCommand;

class MakeApplicationToken extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:app-token
                            {name : The name of the application}
                            {--json : Output in JSON format}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate a new application token for API access';

    /**
     * Execute the console command.
     * @throws RandomException
     */
    public function handle(): int
    {
        $name = $this->argument('name');

        // Check if an app with this name exists
        if (Application::where('name', $name)->exists()) {
            $this->error("An application named '{$name}' already exists.");
            return BaseCommand::FAILURE;
        }

        // Create the token (plain-text)
        $token = Application::createToken($name);

        if ($this->option('json')) {
            $this->line(json_encode([
                'name' => $name,
                'token' => $token,
            ], JSON_PRETTY_PRINT));
        } else {
            $this->info("Application '{$name}' created successfully!");
            $this->line("");
            $this->line("▼ Save this token now — you won't be able to retrieve it again:");
            $this->line("");
            $this->warn($token);
            $this->line("");
        }

        return BaseCommand::SUCCESS;
    }
}
