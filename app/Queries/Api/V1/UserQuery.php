<?php

namespace App\Queries\Api\V1;

use App\Models\User;

class UserQuery extends QueryProfile
{
    protected function model(): string
    {
        return User::class;
    }

    protected function filters(): array
    {
        return [
            'id',
            'name',
            'surname',
            'patronymic',
            'avatar',
            'avatarThumb',
            'email',
            'emailVerifiedAt',
            'createdAt',
            'updatedAt',
            'deletedAt',
        ];
    }

    protected function includes(): array
    {
        return [
            'profile',
            'roles',
            'positions',
            'departments',
            'languages',
            'equipments',
            'experiences',
            'educations',
            'events',
            'events.performer',
        ];
    }

    protected function sorts(): array
    {
        return [
            'id',
            'name',
            'surname',
            'patronymic',
            'avatar',
            'avatarThumb',
            'email',
            'emailVerifiedAt',
            'createdAt',
            'updatedAt',
            'deletedAt',
        ];
    }

    protected function fields(): array
    {
        return [
            'id',
            'name',
            'surname',
            'patronymic',
            'avatar',
            'avatarThumb',
            'email',
            'emailVerifiedAt',
            'createdAt',
            'updatedAt',
            'deletedAt',
        ];
    }
}
