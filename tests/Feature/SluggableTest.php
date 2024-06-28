<?php

namespace AesirCloud\Sluggable\Tests\Feature;

use AesirCloud\Sluggable\Tests\TestCase;

// Use the TestCase class for all tests in this file
uses(TestCase::class);

it('can publish the configuration file', function () {
    $this->artisan('vendor:publish', ['--provider' => 'AesirCloud\Sluggable\SluggableServiceProvider', '--tag' => 'config'])
        ->assertExitCode(0);

    $this->assertFileExists(config_path('sluggable.php'));
});

it('merges the configuration file', function () {
    $config = config('sluggable.source');
    expect($config)->toBe('title');
});