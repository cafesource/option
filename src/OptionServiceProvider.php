<?php

namespace Cafesource\Option;

use Cafesource\Foundation\Facades\Cafesource;
use Cafesource\Option\Http\Livewire\Index;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Container\Container as Application;

class OptionServiceProvider extends ServiceProvider
{
    protected $config = __DIR__ . '/../config/option.php';

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

        $this->loadAdminConfig();
    }

    public function mergeConfigs()
    {
        $this->mergeConfigFrom($this->config, 'option');
    }

    /**
     * The set option singleton
     *
     * @param $app
     */
    protected function registerManager( Application $app )
    {
        $app->singleton('cafesource.option', function ( $app ) {
            return new Options($app[ 'config' ][ 'option' ]);
        });
    }

    /**
     * The option binding
     *
     * @param $app
     */
    protected function registerBindings( Application $app )
    {
        $app->bind('cafesource.option', function ( $app ) {
            return new Options($app[ 'config' ][ 'option' ]);
        });
    }

    /**
     * Load admin panel config
     */
    public function loadAdminConfig()
    {
        $prefix = 'admin/settings';
        if ( function_exists('admin') )
            $prefix = admin()->prefix('settings');

        Cafesource::addRoute('options', __DIR__ . '/../routes/web.php', [
            'prefix'     => $prefix,
            'name'       => 'admin.options.',
            'middleware' => 'admin'
        ])->addLivewireComponent([
            'admin.option.index' => Index::class
        ]);

        $this->loadBookmarks();
        $this->loadMenus();
    }

    /**
     * Load the settings menus
     */
    private function loadMenus()
    {
        if ( !function_exists('adminMenu') )
            return;

        adminMenu()->category('general', function ( $category ) {
            $category->add('options', [
                'title'       => __('Settings'),
                'route'       => route('admin.options.index'),
                'active'      => request()->is('admin/settings'),
                'icon'        => 'fad fa-cogs',
                'priority'    => 20,
                'permission'  => 'options',
                'role'        => 'administrator',
                'roles'       => ['administrator', 'editor'],
                'keywords'    => ['options', 'create', 'list'],
                'description' => 'The settings management'
            ]);
        });
    }

    private function loadBookmarks()
    {
//        addAdminBookmark('settings', [
//            'title' => __('Settings'),
//            'route' => route('admin.options.index'),
//            'icon'  => 'far fa-cogs'
//        ], 21);
    }
}
