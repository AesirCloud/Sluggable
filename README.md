# Generate unique slugs when creating or updating Eloquent models

`sluggable` is a Laravel package that generates unique slugs for Eloquent models. It can be used to automatically generate slugs when creating or updating models.

---

[![Packagist Version](https://img.shields.io/packagist/v/aesircloud/sluggable)](https://packagist.org/packages/aesircloud/sluggable)
[![MIT Licensed](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![GitHub Workflow Status](https://img.shields.io/github/actions/workflow/status/aesircloud/sluggable/tests.yml)](https://github.com/aesircloud/sluggable/actions)
[![Total Downloads](https://img.shields.io/packagist/dt/aesircloud/sluggable.svg?style=flat-square)](https://packagist.org/packages/aesircloud/sluggable)

## Installation

You can install the package via composer:

```bash
composer require aesircloud/sluggable
```

## Publish the configuration file
```bash
php artisan vendor:publish --provider="AesirCloud\Sluggable\SluggableServiceProvider"
```

## Usage

To use the package, add the `Sluggable` trait to your Eloquent model and optionally define the `$slugSource` property to configure the slug generation, the default value is `name`:

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use AesirCloud\Sluggable\Traits\Sluggable;

class Post extends Model
{
    use Sluggable;

    protected $fillable = ['title', 'slug'];

    protected $slugSource = 'title'; // or 'description', or any other field
}
```

You will need to add a slug column to your table. You can do this by creating a migration:

```bash
php artisan make:migration add_slug_to_posts_table --table=posts
```

```php
    <?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->string('slug')->unique()->after('title');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropColumn('slug');
        });
    }
};

```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Security

If you've found a bug regarding security please mail [security@aesircloud.com](mailto:security@aesircloud.com) instead of using the issue tracker.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.