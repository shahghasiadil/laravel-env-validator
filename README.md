# Laravel Env Validator

The `laravel-env-validator` package provides a way to validate your `.env` configuration values in a Laravel application.

## Installation

1. **Install via Composer**:

   ```bash
   composer require shahghasiadil/laravel-env-validator
   ```

2. **Publish the Configuration**:

   ```bash
   php artisan vendor:publish --tag=config --provider="LaravelEnvValidator\LaravelEnvValidatorServiceProvider"
   ```

## Usage

1. **Generating Validation Rules from .env**:

   To generate validation rules based on your `.env` values:

   ```bash
   php artisan env:generate-rules
   ```

   This will read your `.env` file, generate validation rules, and store them in `config/env-validator.php`.

2. **Checking Env Validity**:

   To validate your current environment based on the generated rules:

   ```bash
   php artisan env:vaildate
   ```

3. **Middleware**:

   Ensure your environment is valid on every request by adding the middleware:

   ```php
   protected $middleware = [
       // other middlewares...
       \LaravelEnvValidator\Middlewares\EnsureValidEnv::class,
   ];
   ```

   Add this to your `app/Http/Kernel.php`.

4. **Customize Validation Rules**:

   To add or modify validation rules, edit the `config/env-validator.php`.

## Configuration

All configuration for this package is stored in the `env-validator.php` config file. It contains an array of validation rules corresponding to each key in your `.env` file.

## Changelog

For a detailed changelog, see the [CHANGELOG](CHANGELOG.md).

## Testing

Run the tests with:

```bash
composer test
```
