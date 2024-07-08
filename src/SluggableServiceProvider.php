<?php

namespace AesirCloud\Sluggable\Traits;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

trait Sluggable
{
    /**
     * Boot the sluggable trait for a model.
     *
     * @return void
     */
    public static function bootSluggable(): void
    {
        static::saving(function ($model) {
            $model->generateSlug();
        });
    }

    /**
     * Find a model by its slug.
     *
     * @param string $slug
     * @return Model|null
     */
    public static function findBySlug($slug)
    {
        return static::where('slug', $slug)->first();
    }

    /**
     * Generate a unique slug for the model.
     *
     * @return void
     */
    protected function generateSlug(): void
    {
        $slug = Str::slug($this->getSlugSource());

        // Ensure the slug is unique
        $slug = $this->makeSlugUnique($slug);

        $this->slug = $slug;
    }

    /**
     * Get the source string for the slug.
     *
     * @return string
     */
    protected function getSlugSource()
    {
        if (property_exists($this, 'slugSource')) {
            return $this->{$this->slugSource};
        }

        return $this->title ?? $this->name ?? 'default';
    }

    /**
     * Make the slug unique.
     *
     * @param string $slug
     * @return string
     */
    protected function makeSlugUnique($slug): string
    {
        $originalSlug = $slug;
        $count = 1;

        while ($this->slugExists($slug)) {
            $slug = "{$originalSlug}-{$count}";
            $count++;
        }

        return $slug;
    }

    /**
     * Check if the slug already exists.
     *
     * @param string $slug
     * @return bool
     */
    protected function slugExists($slug): bool
    {
        return static::where('slug', $slug)->exists();
    }
}
