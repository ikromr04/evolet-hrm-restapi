<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\JsonApi\JsonApiResource;

class RoleResource extends JsonApiResource
{
    public $relationships = [
        'users' => UserResource::class,
    ];

    public function toAttributes(Request $request): array
    {
        return [
            'name' => $this->name,
            'displayName' => $this->display_name,
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at,
        ];
    }
}
