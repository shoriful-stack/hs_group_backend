<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class generalSettingRequest extends FormRequest
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
            'title'      => ['required', 'string'],
            'language_id'      => ['nullable', 'numeric'],
            'favicon' => ['nullable', 'file', 'image', 'mimes:jpg,jpeg,png,svg', 'max:2048'],
            'logo_header' => ['nullable', 'file', 'image', 'mimes:jpg,jpeg,png,svg', 'max:2048'],
            'logo_footer' => ['nullable', 'file', 'image', 'mimes:jpg,jpeg,png,svg', 'max:2048'],
            'description'      => ['nullable', 'string'],
            'keywords'      => ['nullable', 'string'],
            'cookies_name'      => ['nullable', 'string'],
        ];
    }
}
