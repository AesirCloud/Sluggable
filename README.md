# Generate unique slugs when creating or updating Eloquent models

`sluggable` is a Laravel package that generates unique slugs for Eloquent models. It can be used to automatically generate slugs when creating or updating models, with flexible options controlled by both a config file and model-level properties.

---

<p align="center">
<a href="https://github.com/aesircloud/sluggable/actions" target="_blank"><img src="https://img.shields.io/github/actions/workflow/status/aesircloud/sluggable/test.yml?branch=main&style=flat-square"/></a>
<a href="https://packagist.org/packages/aesircloud/sluggable" target="_blank"><img src="https://img.shields.io/packagist/v/aesircloud/sluggable.svg?style=flat-square"/></a>
<a href="https://packagist.org/packages/aesircloud/sluggable" target="_blank"><img src="https://img.shields.io/packagist/dt/aesircloud/sluggable.svg?style=flat-square"/></a>
<a href="https://packagist.org/packages/aesircloud/sluggable" target="_blank"><img src="https://img.shields.io/packagist/l/aesircloud/sluggable.svg?style=flat-square"/></a>
</p>

## Installation

You can install the package via Composer:

```bash
  composer require aesircloud/sluggable
```

## Publish the configuration file
```bash
  php artisan vendor:publish --provider="AesirCloud\Sluggable\SluggableServiceProvider"
```

## Usage

Add the `Sluggable` trait to your model:

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use AesirCloud\Sluggable\Traits\Sluggable;

class Post extends Model
{
    use Sluggable;

    protected $fillable = ['title', 'slug'];

    /**
     * Optionally override the default slug source field.
     *
     * By default, the package uses whatever is set in 'sluggable.source'
     * or falls back to 'name' on your model. Here, we explicitly use 'title'.
     */
    protected $slugSource = 'title';

    /**
     * If you want to allow the slug to be updated automatically when 'title' changes:
     */
    protected $slugUpdatable = true;

    /**
     * If you want a different slug column in your database table:
     */
    protected $slugColumn = 'url_slug';
}
```

## 2. Migrate the Slug Column

Ensure your table has a suitable column for the slug:

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
    public function up(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            // Make sure it's unique or at least indexed if you rely on uniqueness.
            $table->string('slug')->unique()->after('title');
        });
    }

    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropColumn('slug');
        });
    }
};
```

## 3. Configuration Options

Open `config/sluggable.php` to see the available options. You can override any of these in your model by defining the corresponding property.

```php
return [
    'source'     => 'name',
    'column'     => 'slug',
    'update'     => false,
    'max_length' => 255,
    'scopes'     => [], // e.g. ['category_id'] to scope uniqueness
];

```
 - source: The default field the slug is generated from if you don’t set $slugSource in the model.
 - column: The column to store the slug.
 - update: Set true to automatically regenerate a slug when the source field changes on update.
 - max_length: Truncates the slug (plus space for numeric suffixes) to this length if specified.
 - scopes: Array of columns to scope uniqueness (e.g., if you only want unique slugs per category_id).

## 4. Route Model Binding (Optional)

If you want to use the slug in your routes, you can override getRouteKeyName() in your model:

```php
public function getRouteKeyName()
{
    return 'slug';
}
```

Then reference it in your routes:

```php
Route::get('/posts/{post:slug}', function (App\Models\Post $post) {
    return $post;
});
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Security

If you've found a bug regarding security please mail [security@aesircloud.com](mailto:security@aesircloud.com) instead of using the issue tracker.

## LICENSE

The MIT License (MIT). Please see [License](LICENSE.md) file for more information.
