<?php

namespace App\Http\Requests\Api\V1;

use App\Enums\EventType;
use App\Models\Event;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UserTransferRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'data.type' => 'required|in:users',
            'data.id' => "required|exists:users,id|in:{$this->route('user')->id}",
            'data.meta.payload.to' => 'nullable|string|max:255',
        ];
    }

    public function mappedAttributes(): array
    {
        return [
            'type' => EventType::TRANSFER,
            'payload' => $this->input('data.meta.payload', null),
            'performer_id' => $this->user()->id,
        ];
    }
}
