<?php

namespace Cafesource\Option;

use Cafesource\Admin\Bookmarks\Bookmark;
use Illuminate\Support\ServiceProvider;
use Cafesource\Admin\Facades\AdminMenu;
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

        $this->loadMenus();
        $this->loadBookmarks();
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

    /**
     * Load the settings menus
     */
    private function loadMenus()
    {
        if ( !class_exists(AdminMenu::class) )
            return;

        AdminMenu::add('settings', function ( $settings ) {
            $settings->add('options', [
                'title'       => __('Settings'),
                'route'       => route('admin.options.index'),
                'active'      => request()->is('admin/settings'),
                'icon'        => 'fal fa-cogs',
                'priority'    => 20,
                'permission'  => 'options',
                'role'        => 'administrator',
                'roles'       => ['administrator', 'editor'],
                'keywords'    => ['options', 'create', 'list'],
                'description' => 'The settings management'
            ]);
        }, 50);
    }

    private function loadBookmarks()
    {
        if ( !class_exists(Bookmark::class) )
            return;

        Bookmark::add('settings', function ( $settings ) {
            $settings->title(__('Settings'))
                ->route(route('admin.options.index'))
                ->icon('fal fa-cog');
        }, 10);
    }
}
