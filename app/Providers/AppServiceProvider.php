<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (env('VERCEL')) {
            // Set storage path to /tmp (writable on Vercel)
            $this->app->useStoragePath(env('VERCEL_STORAGE_PATH', '/tmp/storage'));

            // Ensure required storage subdirectories exist
            $directories = [
                'app',
                'framework/cache/data',
                'framework/sessions',
                'framework/views',
                'framework/testing',
                'logs',
            ];

            foreach ($directories as $directory) {
                $path = storage_path($directory);
                if (! is_dir($path)) {
                    mkdir($path, 0755, true);
                }
            }
        }
    }
}
