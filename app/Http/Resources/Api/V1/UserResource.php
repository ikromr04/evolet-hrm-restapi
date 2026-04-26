<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\JsonApi\JsonApiResource;

class UserResource extends JsonApiResource
{
    public $relationships = [
        'profile' => ProfileResource::class,
        'roles' => RoleResource::class,
        'positions' => PositionResource::class,
        'departments' => DepartmentResource::class,
        'languages' => LanguageResource::class,
        'equipments' => EquipmentResource::class,
        'experiences' => ExperienceResource::class,
        'educations' => EducationResource::class,
        'events' => EventResource::class,
    ];

    public function toAttributes(Request $request): array
    {
        return [
            'name' => $this->name,
            'surname' => $this->surname,
            'patronymic' => $this->patronymic,
            'avatar' => $this->avatar ? asset("storage/{$this->avatar}") : null,
            'avatarThumb' => $this->avatar_thumb ? asset("storage/{$this->avatar_thumb}") : null,
            'email' => $this->email,
            'emailVerifiedAt' => $this->email_verified_at,
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at,
            'deletedAt' => $this->deleted_at,
        ];
    }
}
