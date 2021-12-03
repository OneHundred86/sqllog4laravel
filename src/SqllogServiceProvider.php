<?php

namespace Oh86\Sqllog;

use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\Application as LaravelApplication;

class SqllogServiceProvider extends ServiceProvider
{
    /**
     * Boot the service provider.
     *
     * @return void
     */
    public function boot()
    {
        $source = realpath($raw = __DIR__.'/../config/sqllog.php') ?: $raw;
        if ($this->app instanceof LaravelApplication && $this->app->runningInConsole()) {
            $this->publishes([$source => config_path('sqllog.php')]);
        }

        //
        Event::listen(QueryExecuted::class, DBQueryListener::class);
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {

    }
}
