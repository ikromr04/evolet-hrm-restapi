<?php

namespace App\Queries\Api\V1;

use App\Models\Department;

class DepartmentQuery extends QueryProfile
{
    protected function model(): string
    {
        return Department::class;
    }

    protected function filters(): array
    {
        return [
            'name',
            'left',
            'right',
            'parent',
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
            'name',
            'left',
            'right',
            'parent',
            'createdAt',
            'updatedAt',
        ];
    }

    protected function fields(): array
    {
        return [
            'id',
            'name',
            'left',
            'right',
            'parent',
            'createdAt',
            'updatedAt',
        ];
    }
}
