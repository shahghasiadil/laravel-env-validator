<?php

namespace LaravelEnvValidator;

use Illuminate\Support\ServiceProvider;
use LaravelEnvValidator\Commands\CheckEnvCommand;
use LaravelEnvValidator\Commands\GenerateEnvRulesCommand;
use LaravelEnvValidator\Contracts\ValidatorContract;

class LaravelEnvValidatorServiceProvider extends ServiceProvider
{
    protected $commands = [
        GenerateEnvRulesCommand::class,
        CheckEnvCommand::class,
    ];

    /**
     * Bootstrap any package services.
     */
    public function boot(): void
    {
        $this->publishes([
            __DIR__.'/../config/env-validator.php' => config_path('env-validator.php'),
        ], 'config');
    }

    public function register()
    {
        $this->app->bind(ValidatorContract::class, EnvValidatorService::class);

        $this->app->singleton('env-validator', function ($app) {
            return new EnvValidatorService();
        });

        if ($this->app->runningInConsole()) {
            $this->commands($this->commands);
        }

        $this->mergeConfigFrom(
            __DIR__.'/../config/env-validator.php', 'env-validator'
        );
    }
}
