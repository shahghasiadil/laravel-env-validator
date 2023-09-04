<?php

namespace LaravelEnvValidator\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;

class GenerateEnvRulesCommand extends Command
{
    protected $signature = 'env:generate-rules';

    protected $description = 'Generate validation rules from .env file';

    public function handle()
    {
        $envPath = base_path('.env');

        if (! File::exists($envPath)) {
            $this->error("The .env file does not exist at: {$envPath}");

            return;
        }

        $envContents = File::get($envPath);
        $lines = explode("\n", $envContents);

        $rules = [];

        foreach ($lines as $line) {
            if (strpos($line, '=') !== false) {
                [$key, $value] = explode('=', $line, 2);
                $value = trim($value);

                if ($value === 'null') {
                    $rules[$key] = 'nullable';
                } elseif ($value !== '') {
                    $rules[$key] = $this->getValidationRule($value);
                }
            }
        }

        Config::set('env-validator.rules', $rules);

        $configPath = config_path('env-validator.php');
        $currentConfig = file_exists($configPath) ? include($configPath) : [];

        $currentConfig['rules'] = $rules;

        File::put($configPath, "<?php\n\nreturn ".var_export($currentConfig, true).';');

        $this->info('Validation rules have been generated and saved to: config/env-validator.php');
        if (! empty($rules)) {
            $this->info('Generated Rules:');
            $this->displayGeneratedRules($rules);
        } else {
            $this->info('No rules were generated.');
        }
    }

    protected function getValidationRule($value)
    {
        if (is_numeric($value)) {
            return 'numeric';
        } elseif ($this->isBooleanValue($value)) {
            return 'boolean';
        } else {
            return 'string';
        }
    }

    protected function isBooleanValue($value)
    {
        return filter_var($value, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE) !== null;
    }

    protected function displayGeneratedRules(array $rules)
    {
        $headers = ['Key', 'Rule'];
        $rows = [];

        foreach ($rules as $key => $rule) {
            $rows[] = [$key, $rule];
        }
        $this->table($headers, $rows, 'box');
    }
}
