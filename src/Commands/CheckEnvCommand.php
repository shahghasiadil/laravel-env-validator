<?php

namespace LaravelEnvValidator\Commands;

use Illuminate\Console\Command;
use LaravelEnvValidator\Exceptions\EnvValidationException;
use LaravelEnvValidator\Facades\EnvValidator;

class CheckEnvCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'env:validate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Validate environment variables against validation rules.';

    /**
     * Execute the console command.
     *
     * Validates the environment variables based on the rules defined.
     * If validation passes, it shows a success message.
     * On failure, it displays the specific validation error.
     */
    public function handle()
    {
        // Attempt to validate the environment variables using the facade
        try {

            EnvValidator::validate();

            $this->info('All environment variables passed validation!');

        } catch (EnvValidationException $e) {
            // If a validation exception is thrown, display its message
            $this->error('Validation error: '.$e->getMessage());
        }
    }
}
