<?php

namespace App\Providers;

use Illuminate\Support\Collection;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Validator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**'
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrap();

        Validator::replacer('max', function ($message, $attribute, $rule, $parameters) {
            if ($rule === 'max' && str_contains($message, 'file')) {
                if (isset($parameters[0])) {
                    $maxInMB = $parameters[0] / 1024;
                    $message = str_replace(':max', $maxInMB . ' MB', $message);
                }
            }

            return $message;
        });
    }
}
