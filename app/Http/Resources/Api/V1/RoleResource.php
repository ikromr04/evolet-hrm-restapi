<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RoleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'type' => 'roles',
            'id' => (string) $this->id,

            'attributes' => [
                'name' => $this->name,
                'displayName' => $this->display_name,
            ],
            'links' => [
                'self' => route('roles.show', $this->id)
            ]
        ];
    }
}
