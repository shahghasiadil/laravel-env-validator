<?php

namespace Tests\Feature\Commands;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use LaravelEnvValidator\Tests\TestCase;

class GenerateEnvRulesCommandTest extends TestCase
{
    protected $envPath;

    protected function setUp(): void
    {
        parent::setUp();
        $this->envPath = base_path('.env');
    }

    protected function tearDown(): void
    {
        if (File::exists($this->envPath)) {
            File::delete($this->envPath);
        }
        parent::tearDown();
    }

    public function test_command_generates_rules_from_env_file()
    {
        // Create a sample .env file
        $envContents = "APP_NAME=Laravel\nAPP_ENV=local\nAPP_KEY=\n";
        File::put($this->envPath, $envContents);

        // Run the command
        Artisan::call('env:generate-rules');

        // Assert that the env-validator.php config file is generated
        $configPath = config_path('env-validator.php');
        $this->assertTrue(File::exists($configPath));

        // Assert that the rules are generated correctly
        $expectedRules = [
            'APP_NAME' => 'string',
            'APP_ENV' => 'string',
        ];
        $config = include $configPath;
        $this->assertEquals($expectedRules, $config['rules']);
    }

    public function test_command_handles_boolean_values()
    {
        // Create a sample .env file with boolean values
        $envContents = "DEBUG=true\nENABLE_FEATURE=false\n";
        File::put($this->envPath, $envContents);

        // Run the command
        Artisan::call('env:generate-rules');

        // Assert that the env-validator.php config file is generated
        $configPath = config_path('env-validator.php');
        $this->assertTrue(File::exists($configPath));

        // Assert that the rules are generated correctly for boolean values
        $expectedRules = [
            'DEBUG' => 'boolean',
            'ENABLE_FEATURE' => 'boolean',
        ];
        $config = include $configPath;
        $this->assertEquals($expectedRules, $config['rules']);
    }
}
