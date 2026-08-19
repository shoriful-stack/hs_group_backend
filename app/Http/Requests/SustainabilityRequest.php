<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SustainabilityRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title'     => ['nullable', 'string', 'max:255'],
            'subtitle'  => ['nullable', 'string'],
            'sub_title' => ['nullable', 'string', 'max:255'],
            'contents'  => ['nullable', 'string'],
            'quote'     => ['nullable', 'string'],
            'closing'   => ['nullable', 'string', 'max:255'],
            'image'     => ['nullable', 'file', 'mimes:jpeg,jpg,png,webp', 'max:4096'],
        ];
    }
}
