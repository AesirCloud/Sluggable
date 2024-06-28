<?php

namespace AesirCloud\Sluggable\Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use AesirCloud\Sluggable\SluggableServiceProvider;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

abstract class TestCase extends Orchestra
{
    protected function getPackageProviders($app): array
    {
        return [
            SluggableServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app): void
    {
        // Load configuration from the tests directory
        $app['config']->set('sluggable', require __DIR__.'/config/sluggable.php');

        // Create test table
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->timestamps();
        });
    }
}
