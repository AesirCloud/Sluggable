<?php

namespace AesirCloud\Sluggable\Tests\Models;

use Illuminate\Database\Eloquent\Model;
use AesirCloud\Sluggable\Traits\Sluggable;

class Post extends Model
{
    use Sluggable;

    protected $fillable = ['title'];

    protected $slugSource = 'title';
}