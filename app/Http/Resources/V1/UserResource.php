<?php

namespace App\Http\Resources\V1;

use App\Traits\Resource\MappedAttributes;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    use MappedAttributes;

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'type' => 'users',
            'id' => (string) $this->id,

            'attributes' => $this->mappedAttributes(),

            'links' => [
                'self' => route('users.show', $this->id),
            ],
        ];
    }

    /**
     * Get any additional data that should be returned with the resource array.
     */
    public function with(Request $request): array
    {
        return [
            'links' => [
                'self' => route('users.show', $this->id),
            ]
        ];
    }
}
