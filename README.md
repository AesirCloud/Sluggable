# Generate unique slugs when creating or updating Eloquent models

`sluggable` is a Laravel package that generates unique slugs for Eloquent models. It can be used to automatically generate slugs when creating or updating models.

## Installation

You can install the package via composer:

```bash
composer require aesircloud/sluggable
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

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Security

If you've found a bug regarding security please mail [security@aesircloud.com](mailto:security@aesircloud.com) instead of using the issue tracker.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.