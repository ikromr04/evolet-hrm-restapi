<?php

namespace App\Traits\Resource;

use Illuminate\Support\Str;

/**
 * Trait MappedAttributes
 *
 * Provides a method to map model attributes to camelCase for API resources.
 * Intended for use in Eloquent models that are serialized via resources.
 */
trait MappedAttributes
{
    /**
     * Get model's attributes as an object with camelCase keys,
     * excluding 'id' by default.
     */
    public function mappedAttributes(): object
    {
        $attributes = collect($this->attributesToArray())
            ->except(['id'])
            ->mapWithKeys(fn($value, $key) => [Str::camel($key) => $value])
            ->toArray();

        return (object) $attributes;
    }
}
