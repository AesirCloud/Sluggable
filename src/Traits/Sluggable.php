<?php

namespace AesirCloud\Sluggable\Traits;

use Illuminate\Support\Facades\Config;
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
        static::creating(function ($model) {
            $model->generateSlug();
        });

        static::updating(function ($model) {
            $model->generateSlug(true);
        });
    }

    /**
     * Find a model by its slug.
     *
     * @param  string  $slug
     * @return Model|null
     */
    public static function findBySlug($slug): ?Model
    {
        $column = (new static)->getSlugColumn();

        return static::where($column, $slug)->first();
    }

    /**
     * Generates (or regenerates) the slug for the model.
     *
     * @param  bool  $onUpdate
     * @return void
     */
    protected function generateSlug(bool $onUpdate = false): void
    {
        // Determine if we should update the slug on model updates
        // Prefer a property on the model, else read from config
        $shouldUpdateSlug = property_exists($this, 'slugUpdatable')
            ? $this->slugUpdatable
            : Config::get('sluggable.update', false);

        // If it's an update, skip if we don't allow updates
        if ($onUpdate && ! $shouldUpdateSlug) {
            return;
        }

        // Determine which field we use as slug source
        $sourceField = $this->determineSourceField();

        // If it's an update, check if the source field is actually dirty
        if ($onUpdate && ! $this->isDirty($sourceField)) {
            // Source not changed, skip
            return;
        }

        // Slugify
        $slug = Str::slug($this->getSlugSource());

        // Optionally truncate to a maximum length (minus room for incremental suffix)
        $maxLength = Config::get('sluggable.max_length', 255);

        $slug = mb_substr($slug, 0, $maxLength);

        // Make it unique within the model scope
        $uniqueSlug = $this->makeSlugUnique($slug);

        // Assign to the slug column
        $this->{$this->getSlugColumn()} = $uniqueSlug;
    }

    /**
     * Determine which field should be checked for changes.
     *
     * @return string
     */
    protected function determineSourceField(): string
    {
        // If the model defines a slugSource property, use that.
        if (property_exists($this, 'slugSource')) {
            return $this->slugSource;
        }

        // Otherwise, read from config (default to 'name')
        return Config::get('sluggable.source', 'name');
    }

    /**
     * Get the source string for the slug.
     *
     * @return string
     */
    protected function getSlugSource(): string
    {
        $sourceField = $this->determineSourceField();

        // Attempt to read from the model attribute
        return $this->{$sourceField}
            ?? $this->title
            ?? $this->name
            ?? 'default';
    }

    /**
     * Get the name of the slug column.
     *
     * @return string
     */
    protected function getSlugColumn(): string
    {
        // If the model defines a slugColumn property, use that.
        if (property_exists($this, 'slugColumn')) {
            return $this->slugColumn;
        }

        // Otherwise, read from config (default to 'slug')
        return Config::get('sluggable.column', 'slug');
    }

    /**
     * Make the slug unique, optionally scoped by certain fields.
     *
     * @param  string  $baseSlug
     * @return string
     */
    protected function makeSlugUnique(string $baseSlug): string
    {
        $slug = $baseSlug;

        $originalSlug = $slug;

        $count = 1;

        while ($this->slugExists($slug)) {
            // If needed, consider leaving space for the numeric suffix
            $maxLength = Config::get('sluggable.max_length', 255);

            // Build new slug with numeric suffix
            $suffix = '-' . $count++;

            // Truncate base if adding suffix might exceed max length
            $trimmedBase = mb_substr($originalSlug, 0, $maxLength - mb_strlen($suffix));

            $slug = $trimmedBase . $suffix;
        }

        return $slug;
    }

    /**
     * Check if the slug already exists in the database.
     * Optionally scope by fields defined in the config (e.g. category_id).
     *
     * @param  string  $slug
     * @return bool
     */
    protected function slugExists(string $slug): bool
    {
        $column = $this->getSlugColumn();

        $query = static::where($column, $slug);

        // If config has scopes, apply them
        $scopes = Config::get('sluggable.scopes', []);

        foreach ($scopes as $scopeColumn) {
            // Only apply if our current model actually has that attribute
            if (isset($this->{$scopeColumn})) {
                $query->where($scopeColumn, $this->{$scopeColumn});
            }
        }

        // Exclude the current model instance when checking (important on updates)
        if ($this->exists) {
            $query->where($this->getKeyName(), '!=', $this->getKey());
        }

        return $query->exists();
    }

    /**
     * Example of how you might set routing to use the slug by default.
     * (Typically placed in your model, not forced by the trait.)
     */
    /*
    public function getRouteKeyName()
    {
        return $this->getSlugColumn(); // e.g. 'slug'
    }
    */
}
