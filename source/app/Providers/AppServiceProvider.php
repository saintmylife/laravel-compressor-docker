<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $dirname = [];
        foreach (glob(__DIR__ . '/../Modules/*', GLOB_ONLYDIR) as $dir) {
            $dirname[] = basename($dir);
        }

        foreach ($dirname as $name) {
            $this->app->bind(
                "App\Modules\\{$name}\Repository\\{$name}RepositoryInterface",
                "App\Modules\\{$name}\Repository\\{$name}RepositoryEloquent"
            );
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
