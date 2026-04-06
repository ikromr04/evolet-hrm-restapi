<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class BaseJsonResource extends JsonResource
{
    /**
     * Get model existing attributes as an object with camelCase keys.
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
