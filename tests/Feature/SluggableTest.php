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

it('can publish the action stub', function () {
    $stubPath = base_path('stubs/action.stub');

    if (file_exists($stubPath)) {
        unlink($stubPath);
    }

    $this->artisan('vendor:publish', [
        '--provider' => 'AesirCloud\Sluggable\SluggableServiceProvider',
        '--tag' => 'actions-stubs',
    ])->assertExitCode(0);

    $this->assertFileExists($stubPath);
});

it('merges the configuration file', function () {
    $config = config('sluggable.source');
    expect($config)->toBe('title');
});

it('runs on a supported Laravel release', function () {
    expect((int) explode('.', app()->version())[0])->toBeIn([12, 13]);
});

it('runs on PHP 8.3 or later', function () {
    expect(PHP_VERSION_ID)->toBeGreaterThanOrEqual(80300);
});
