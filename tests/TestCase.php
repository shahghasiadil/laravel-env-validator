<?php

namespace LaravelEnvValidator\Tests;

use LaravelEnvValidator\LaravelEnvValidatorServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

abstract class TestCase extends Orchestra
{
    /**
     * Set up the test environment.
     */
    protected function setUp(): void
    {
        parent::setUp();

        // Any custom setup logic for each test goes here.
    }

    /**
     * Define package service providers required for tests.
     *
     * @param  \Illuminate\Foundation\Application  $app
     */
    protected function getPackageProviders($app): array
    {
        return [
            LaravelEnvValidatorServiceProvider::class,
        ];
    }

    /**
     * Get the environment setup for tests.
     *
     * @param  \Illuminate\Foundation\Application  $app
     */
    protected function getEnvironmentSetUp($app): void
    {
        // Here you can define environment setup.
        // For example, database configurations, config modifications, etc.
    }
}
