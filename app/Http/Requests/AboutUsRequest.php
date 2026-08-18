<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AboutUsRequest extends FormRequest
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
            'title' => [
                'required',
                'string',
            ],
            'language_id' => ['nullable', 'numeric'],
            'contents' => ['nullable', 'string'],
            'images'   => ['nullable', 'array', 'max:4'],
            'images.*' => ['nullable', 'file', 'mimes:jpeg,jpg,png,webp', 'max:2024'],
        ];
    }
}
