<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Sluggable Configuration
    |--------------------------------------------------------------------------
    |
    | source        - Default source field for the slug (e.g. 'title' or 'name')
    | column        - The database column where the slug is stored
    | update        - Whether to regenerate slug on model updates (default: false)
    | max_length    - If you want to truncate the generated slug to this length
    | scopes        - An array of column names to scope slug uniqueness by
    |
    */

    'source'      => 'name',
    'column'      => 'slug',
    'update'      => false,
    'max_length'  => 255,
    'scopes'      => [],  // e.g. ['category_id']
];