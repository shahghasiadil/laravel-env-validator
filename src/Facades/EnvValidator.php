<?php

namespace LaravelEnvValidator\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static bool validate(array $configKeys = [])
 *
 * @see \LaravelEnvValidator\EnvValidatorService
 */
class EnvValidator extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * This method tells Laravel which binding in the service container the facade should resolve to.
     * In this case, it'll look for a service bound as 'env-validator'.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'env-validator';  // This binding should be set up in your service provider
    }
}
