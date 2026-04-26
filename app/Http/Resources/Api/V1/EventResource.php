<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\JsonApi\JsonApiResource;

class EventResource extends JsonApiResource
{
    /**
     * The resource's relationships.
     */
    public $relationships = [
        'performer' => UserResource::class,
    ];

    public function toAttributes(Request $request): array
    {
        return [
            'type' => $this->type,
            'payload' => $this->payload,
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at,
        ];
    }
}
