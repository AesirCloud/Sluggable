<?php

namespace AesirCloud\Sluggable\Tests\Models;

use Illuminate\Database\Eloquent\Model;
use AesirCloud\Sluggable\Traits\Sluggable;

class Post extends Model
{
    use Sluggable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['title'];

    /**
     * The column to store the slug in.
     *
     * @var string
     */
    protected $slugSource = 'title';

    /**
     * Explicitly allow slug updates on this model.
     */
    protected $slugUpdatable = true;
}