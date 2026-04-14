<?php

namespace App\Queries\Api\V1;

use App\Models\Profile;

class ProfileQuery extends QueryProfile
{
    protected function model(): string
    {
        return Profile::class;
    }

    protected function filters(): array
    {
        return [
            'birthDate',
            'sex',
            'nationality',
            'citizenship',
            'address',
            'tel1',
            'tel2',
            'familyStatus',
            'children',
            'startedWorkAt',
            'createdAt',
            'updatedAt',
        ];
    }

    protected function includes(): array
    {
        return [
            'user',
        ];
    }

    protected function sorts(): array
    {
        return [
            'id',
            'birthDate',
            'sex',
            'nationality',
            'citizenship',
            'address',
            'tel1',
            'tel2',
            'familyStatus',
            'children',
            'startedWorkAt',
            'createdAt',
            'updatedAt',
        ];
    }

    protected function fields(): array
    {
        return [
            'id',
            'birthDate',
            'sex',
            'nationality',
            'citizenship',
            'address',
            'tel1',
            'tel2',
            'familyStatus',
            'children',
            'startedWorkAt',
            'createdAt',
            'updatedAt',
        ];
    }
}
