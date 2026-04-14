<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\JsonApi\JsonApiResource;

class PositionResource extends JsonApiResource
{
    public $relationships = [
        'users' => UserResource::class,
    ];

    public function toAttributes(Request $request): array
    {
        return [
            'name' => $this->name,
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at,
        ];
    }
}
