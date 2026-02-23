<?php

namespace Sirgrimorum\AutoMenu;

use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\Facades\Blade;

class AutoMenuServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/Config/automenu.php' => config_path('sirgrimorum/automenu.php'),
                ], 'config');
        $this->loadViewsFrom(__DIR__ . '/Views', 'automenu');
        $this->publishes([
            __DIR__ . '/Views' => resource_path('views/vendor/sirgrimorum/automenu'),
                ], 'views');
        $this->loadTranslationsFrom(__DIR__ . '/Lang', 'automenu');
        $this->publishes([
            __DIR__ . '/Lang' => resource_path('lang/vendor/automenu'),
                ], 'lang');

        Blade::directive('load_automenu', function($expression) {
            $auxExpression = explode(',', str_replace(['(', ')', ' ', '"', "'"], '', $expression));
            if (count($auxExpression)>2) {
                $id = $auxExpression[0];
                $config = $auxExpression[1];
                $automenu = $auxExpression[2];
            } elseif (count($auxExpression)>1) {
                $id = $auxExpression[0];
                $config = $auxExpression[1];
                $automenu = "";
            } elseif (count($auxExpression)>0) {
                $id = $auxExpression[0];
                $config = "";
                $automenu = "";
            }else{
                $id = "";
                $config = "";
                $automenu = "";
            }
            return AutoMenu::buildAutoMenu($id, $config, $automenu);
        });
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
                __DIR__ . '/Config/automenu.php', 'sirgrimorum.automenu'
        );
        $loader = AliasLoader::getInstance();
            $loader->alias(
                    'AutoMenu', AutoMenu::class
            );
        $this->app->singleton(AutoMenu::class, function($app) {
            return new AutoMenu($app);
        });
    }
}