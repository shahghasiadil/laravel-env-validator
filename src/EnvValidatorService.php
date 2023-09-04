<?php

namespace LaravelEnvValidator;

use Illuminate\Support\Facades\Validator;
use LaravelEnvValidator\Contracts\ValidatorContract;
use LaravelEnvValidator\Exceptions\EnvValidationException;

class EnvValidatorService implements ValidatorContract
{
    /**
     * Validates the given configuration keys against the defined rules.
     *
     * @param  array  $configKeys Configuration keys to validate. Defaults to all defined rules.
     *
     * @throws EnvValidationException if validation fails.
     */
    public function validate(array $configKeys = []): bool
    {
        $rules = $this->getValidationRules();

        if (empty($configKeys)) {
            $configKeys = array_keys($rules);
        }

        $dataToValidate = $this->getConfigData($configKeys);
        $validator = $this->makeValidator($dataToValidate, $rules);

        if ($validator->fails()) {
            throw new EnvValidationException($validator->errors()->first());
        }

        return true;
    }

    /**
     * Fetches validation rules from the configuration.
     */
    protected function getValidationRules(): array
    {
        return config('env-validator.rules', []);
    }

    /**
     * Fetches configuration data for the given keys.
     *
     * @param  array  $configKeys Configuration keys.
     */
    protected function getConfigData(array $configKeys): array
    {
        return collect($configKeys)->mapWithKeys(function ($key) {
            return [$key => env($key)];
        })->all();
    }

    /**
     * Creates a new Validator instance.
     *
     * @param  array  $dataToValidate Data to be validated.
     * @param  array  $rules Validation rules.
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function makeValidator(array $dataToValidate, array $rules)
    {
        return Validator::make($dataToValidate, $rules);
    }
}
