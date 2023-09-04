<?php

namespace LaravelEnvValidator\Contracts;

interface ValidatorContract
{
    /**
     * Validate the provided configuration keys.
     *
     * @param  array  $configKeys An array of configuration keys to validate.
     * @return bool Returns true if validation succeeds, otherwise throws an exception.
     *
     * @throws \LaravelEnvValidator\Exceptions\EnvValidationException
     */
    public function validate(array $configKeys = []): bool;
}
