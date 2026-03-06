<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
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
            'data.type' => ['required', 'in:tokens'],
            'data.attributes.login' => ['required', 'string'],
            'data.attributes.password' => ['required', 'string']
        ];
    }

    public function credentials(): array
    {
        return [
            'login' => $this->input('data.attributes.login'),
            'password' => $this->input('data.attributes.password')
        ];
    }
}
