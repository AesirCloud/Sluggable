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

it('runs on Laravel 12', function () {
    expect(str_starts_with(app()->version(), '12.'))->toBeTrue();
});

it('runs on PHP 8.4', function () {
    expect(PHP_VERSION_ID)->toBeGreaterThanOrEqual(80400);
});
