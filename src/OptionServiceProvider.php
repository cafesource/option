<?php

namespace Cafesource\Option;

use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Container\Container as Application;

class OptionServiceProvider extends ServiceProvider
{
    protected string $config = __DIR__ . '/../config/option.php';

    /**
     * Option Service Provider Register
     */
    public function register()
    {
        $this->mergeConfigs();
        $this->registerManager($this->app);
        $this->registerBindings($this->app);
    }

    /**
     * Boot
     *
     * Set option configs
     */
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/Database/Migrations/');
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'option');

        $this->publishes([
            $this->config => config_path('option.php')
        ]);
    }

    public function mergeConfigs()
    {
        $this->mergeConfigFrom($this->config, 'option');
    }

    /**
     * The set option singleton
     *
     * @param Application $app
     */
    protected function registerManager( Application $app )
    {
        $app->singleton('cafesource.option', function ( $app ) {
            return new Option($app[ 'config' ][ 'option' ]);
        });
    }

    /**
     * The option binding
     *
     * @param Application $app
     */
    protected function registerBindings( Application $app )
    {
        $app->bind('cafesource.option', function ( $app ) {
            return new Option($app[ 'config' ][ 'option' ]);
        });
    }
}
