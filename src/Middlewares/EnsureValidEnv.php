<?php

namespace LaravelEnvValidator\Middlewares;

use Closure;
use LaravelEnvValidator\Facades\EnvValidator;

class EnsureValidEnv
{
    public function handle($request, Closure $next)
    {
        if (! EnvValidator::validate()) {
            abort(500, 'Invalid Environment Configuration');
        }

        return $next($request);
    }
}
