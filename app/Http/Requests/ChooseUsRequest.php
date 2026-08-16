<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChooseUsRequest extends FormRequest {
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array {
        return [
            'language_id'                  => ['nullable', 'numeric'],
            'title'                        => ['required', 'string', 'max:255'],
            'content'                      => ['required', 'string'],
            'image'                        => ['nullable', 'file', 'image', 'mimes:jpg,jpeg,png,svg,webp', 'max:2048'],
            'features'                     => ['nullable', 'array'],
            'features.*.icon'              => ['nullable', 'string', 'max:255'],
            'features.*.title'             => ['required_with:features', 'string', 'max:255'],
            'features.*.short_description' => ['nullable', 'string'],
        ];
    }
}
