<?php

namespace App\Providers;

use App\Services\FileStructureService;
use Illuminate\Support\ServiceProvider;

class FileStructureServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(FileStructureService::class, function ($app) {
            return new FileStructureService();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
