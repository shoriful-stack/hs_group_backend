<?php

namespace App\Http\Requests;

use App\Enums\Status;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Validation\Rules\Password;

class UserRequest extends FormRequest
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
        $userId = $this->route('user') ? $this->route('user')->id : null;
        return [
            'name' => ['required','string'],
            'branch_id' => ['required', 'numeric'],
            'is_active' => [new Enum(Status::class)],
            'email' => ['required', 'string', Rule::unique('users', 'email')->ignore($userId)],
            'password' => ['nullable', 'string', 'confirmed'],
            'role_id' => ['required', 'numeric'],
        ];
    }
}
