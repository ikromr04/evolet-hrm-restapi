<?php

namespace App\Http\Requests\V1;

use App\Enums\LangLevel;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class UserStoreRequest extends FormRequest
{
    protected array $addedAttributes = [];

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'data.type' => 'required|in:users',
            'data.attributes.name' => 'required|string|max:255',
            'data.attributes.surname' => 'required|string|max:255',
            'data.attributes.patronymic' => 'nullable|string|max:255',
            'data.attributes.email' => 'required|string|email|max:255|unique:users,email',
            'data.attributes.password' => 'nullable|string|min:6|confirmed',
            'data.attributes.avatar' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',

            'data.relationships' => 'nullable|array',

            'data.relationships.details' => 'nullable|array',
            'data.relationships.details.data' => 'required_with:data.relationships.details|array',
            'data.relationships.details.data.type' => 'required_with:data.relationships.details.data|in:user_details',
            'data.relationships.details.data.id' => 'required_with:data.relationships.details.data|exists:user_details,id',

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

            'data.relationships.experiences' => 'nullable|array',
            'data.relationships.experiences.data' => 'required_with:data.relationships.experiences|array',
            'data.relationships.experiences.data.*.type' => 'required_with:data.relationships.experiences.data|in:experiences',
            'data.relationships.experiences.data.*.id' => 'required_with:data.relationships.experiences.data|exists:experiences,id',

            'data.relationships.educations' => 'nullable|array',
            'data.relationships.educations.data' => 'required_with:data.relationships.educations|array',
            'data.relationships.educations.data.*.type' => 'required_with:data.relationships.educations.data|in:educations',
            'data.relationships.educations.data.*.id' => 'required_with:data.relationships.educations.data|exists:educations,id',

            'data.relationships.equipments' => 'nullable|array',
            'data.relationships.equipments.data' => 'required_with:data.relationships.equipments|array',
            'data.relationships.equipments.data.*.type' => 'required_with:data.relationships.equipments.data|in:equipments',
            'data.relationships.equipments.data.*.id' => 'required_with:data.relationships.equipments.data|exists:equipments,id',

            'data.relationships.languages' => 'nullable|array',
            'data.relationships.languages.data' => 'required_with:data.relationships.languages|array',
            'data.relationships.languages.data.*.type' => 'required_with:data.relationships.languages.data|in:languages',
            'data.relationships.languages.data.*.id' => 'required_with:data.relationships.languages.data|exists:languages,id',
            'data.relationships.languages.data.*.meta.level' => 'required_with:data.relationships.languages.data|in:' . implode(',', LangLevel::values()),
        ];
    }

    public function mappedAttributes(): array
    {
        return [
            'name' => $this->input('data.attributes.name'),
            'surname' => $this->input('data.attributes.surname'),
            'patronymic' => $this->input('data.attributes.patronymic'),
            'email' => $this->input('data.attributes.email'),
            'password' => $this->input('data.attributes.password') ?: Str::random(12),
            ...$this->addedAttributes
        ];
    }

    public function addAttributes(array $attributes): void
    {
        $this->addedAttributes = [
            ...$this->addedAttributes,
            ...$attributes,
        ];
    }
}
