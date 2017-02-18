<?php

namespace CreateSites\IMVK;

use Illuminate\Support\ServiceProvider;

class IMVKServiceProvider extends ServiceProvider
{
    public function boot()
    {
        //Указываем что пакет должен опубликовать при установке
        $this->publishes([__DIR__ . '/../public/' => public_path() . "/vendor/im_vk/"], 'assets');
        $this->publishes([__DIR__ . '/../database/' => base_path("database")], 'database');
        $this->publishes([__DIR__ . '/../components/' => base_path("resources") . '/assets/js/components/'], 'components');

        // Routing
        if (! $this->app->routesAreCached()) {
            include __DIR__ . '/routes.php';
        }

        //Указывам где искать вью и какой неймспейс им задать
        $this->loadViewsFrom(__DIR__.'/../views', 'crsites_im');

    }

    public function register()
    {
        $this->app['IM_VK'] = $this->app->share(function($app)
        {
            return new IM_VK;
        });

        $this->app->booting(function()
        {
            $loader = \Illuminate\Foundation\AliasLoader::getInstance();
            $loader->alias('IM_VK', 'CreateSites\IMVK\Facades\IMVKFacade');
        });
    }
}