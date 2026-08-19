<?php

namespace App\Http\Requests;

use App\Enums\Status;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class TestimonialRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'        => ['required', 'string', 'max:255'],
            'role'        => ['nullable', 'string', 'max:255'],
            'quote'       => ['required', 'string'],
            'language_id' => ['nullable', 'numeric'],
            'image'       => ['nullable', 'file', 'mimes:jpeg,jpg,png,webp', 'max:2024'],
            'status'      => ['nullable', new Enum(Status::class)],
        ];
    }
}
