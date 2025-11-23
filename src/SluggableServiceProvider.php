<?php

namespace AesirCloud\Sluggable;

use Illuminate\Support\ServiceProvider;

class SluggableServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any package services.
     *
     * @return void
     */
    public function boot()
    {
        // Publish the configuration file
        $this->publishes([
            __DIR__.'/../config/sluggable.php' => config_path('sluggable.php'),
        ], 'config');

        // Publish the action stub
        $this->publishes([
            __DIR__.'/../stubs/action.stub' => base_path('stubs/action.stub'),
        ], 'actions-stubs');
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        // Merge the configuration file
        $this->mergeConfigFrom(
            __DIR__.'/../config/sluggable.php',
            'sluggable'
        );
    }
}
