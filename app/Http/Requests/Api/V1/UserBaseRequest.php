<?php

namespace App\Http\Requests\Api\V1;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class UserBaseRequest extends FormRequest
{
    protected array $relationshipRules = [
        'data.relationships' => 'nullable|array',

        'data.relationships.roles' => 'nullable|array',
        'data.relationships.roles.data' => 'required_with:data.relationships.roles|array',
        'data.relationships.roles.data.*.type' => 'required_with:data.relationships.roles.data|in:roles',
        'data.relationships.roles.data.*.id' => 'required_with:data.relationships.roles.data|exists:roles,id',

        'data.relationships.positions' => 'nullable|array',
        'data.relationships.positions.data' => 'required_with:data.relationships.positions|array',
        'data.relationships.positions.data.*.type' => 'required_with:data.relationships.positions.data|in:positions',
        'data.relationships.positions.data.*.id' => 'required_with:data.relationships.positions.data|exists:positions,id',

        'data.relationships.departments' => 'nullable|array',
        'data.relationships.departments.data' => 'required_with:data.relationships.departments|array',
        'data.relationships.departments.data.*.type' => 'required_with:data.relationships.departments.data|in:departments',
        'data.relationships.departments.data.*.id' => 'required_with:data.relationships.departments.data|exists:departments,id',

        'data.relationships.languages' => 'nullable|array',
        'data.relationships.languages.data' => 'required_with:data.relationships.languages|array',
        'data.relationships.languages.data.*.type' => 'required_with:data.relationships.languages.data|in:languages',
        'data.relationships.languages.data.*.id' => 'required_with:data.relationships.languages.data|exists:languages,id',
    ];

    public function mappedRelationships(): array
    {
        $relationships = [];

        foreach (User::RELATIONSHIPS as $relationshipName) {
            if ($this->has("data.relationships.$relationshipName")) {
                $relationships[$relationshipName] = collect(
                    $this->input("data.relationships.$relationshipName.data", [])
                )
                    ->pluck('id')
                    ->map(fn($id) => (int) $id)
                    ->toArray();
            }
        }

        return $relationships;
    }

    public function mappedAttributes(): array
    {
        $attributes = array_filter([
            'name' => $this->input('data.attributes.name'),
            'surname' => $this->input('data.attributes.surname'),
            'patronymic' => $this->input('data.attributes.patronymic'),
            'avatar' => $this->file('data.attributes.avatar'),
            'email' => $this->input('data.attributes.email'),
            'password' => $this->input('data.attributes.password'),
        ], fn($value) => !is_null($value));

        if ($this->routeIs('users.store')) {
            $attributes['password'] = $this->input('data.attributes.password') ?: Str::random(12);
        }

        return $attributes;
    }
}
