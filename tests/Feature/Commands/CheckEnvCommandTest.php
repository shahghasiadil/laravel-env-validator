<?php

namespace LaravelEnvValidator\Tests\Feature\Commands;

use Illuminate\Support\Facades\Artisan;
use LaravelEnvValidator\Exceptions\EnvValidationException;
use LaravelEnvValidator\Facades\EnvValidator;
use LaravelEnvValidator\Tests\TestCase;
use Mockery;

class CheckEnvCommandTest extends TestCase
{
    protected function tearDown(): void
    {
        // Ensure Mockery expectations are verified
        Mockery::close();
        parent::tearDown();
    }

    public function test_command_shows_success_on_valid_env()
    {
        // Mock the EnvValidator facade to always return true on validation
        $mock = Mockery::mock('overload:'.EnvValidator::class);
        $mock->shouldReceive('validate')->once()->andReturnTrue();

        Artisan::call('env:validate');
        $output = Artisan::output();

        $this->assertStringContainsString('All environment variables passed validation!', $output);
    }

    public function test_command_shows_error_on_invalid_env()
    {
        // Mock the EnvValidator facade to throw an exception on validation
        $exceptionMessage = 'app.key is missing or invalid.';
        $mock = Mockery::mock('overload:'.EnvValidator::class);
        $mock->shouldReceive('validate')->once()->andThrow(new EnvValidationException($exceptionMessage));

        Artisan::call('env:validate');
        $output = Artisan::output();

        $this->assertStringContainsString('Validation error: '.$exceptionMessage, $output);
    }
}
