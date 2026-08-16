<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactUsRequest extends FormRequest {
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
            'image'           => ['nullable', 'file', 'max:2048', 'mimes:png,jpeg,jpg,svg'],
            'address'         => ['nullable', 'string'],
            'lat'             => ['nullable', 'numeric'],
            'lang'            => ['nullable', 'numeric'],
            'map'             => ['nullable', 'string'],
            'primary_phone'   => ['nullable', 'string'],
            'secondary_phone' => ['nullable', 'string'],
            'primary_email'   => ['nullable', 'email'],
            'secondary_email' => ['nullable', 'email'],
            'whatsapp_number' => ['nullable', 'string'],
            'language_id'     => ['nullable', 'numeric'],
        ];
    }
}
