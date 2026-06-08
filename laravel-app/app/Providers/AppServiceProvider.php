<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Console\Commands\MakeDataCommand; // Подключаем нашу команду

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
        // Регистрируем команду для консоли
        if ($this->app->runningInConsole()) {
            $this->commands([
                MakeDataCommand::class,
            ]);
        }
    }
}