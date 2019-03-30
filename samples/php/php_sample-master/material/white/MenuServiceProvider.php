<?php
namespace App\Providers;

use Lavender\Support\ServiceProvider;
use App\Services\MenuBuilder;

class MenuServiceProvider extends ServiceProvider
{

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            'menu.builder',
        ];
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerMenuBuilder();
    }


    private function registerMenuBuilder()
    {
        $this->app->singleton('menu.builder', function ($app){

            return new MenuBuilder();

        });
    }

}

