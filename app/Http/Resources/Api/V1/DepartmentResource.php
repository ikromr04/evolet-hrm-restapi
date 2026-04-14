<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\JsonApi\JsonApiResource;

class DepartmentResource extends JsonApiResource
{
    public $relationships = [
        'users' => UserResource::class,
    ];

    public function toAttributes(Request $request): array
    {
        return [
            'name' => $this->name,
            'left' => (string) $this->_lft,
            'right' => (string) $this->_rgt,
            'parent' => (string) $this->parent_id,
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at,
        ];
    }
}
