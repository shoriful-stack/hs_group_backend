<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class HomeSettingRequest extends FormRequest {
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
            'section_enable'      => ['nullable', 'boolean'],
            'brand_enable'        => ['nullable', 'boolean'],
            'blog_enable'         => ['nullable', 'boolean'],
            'video_enable'        => ['nullable', 'boolean'],
            'video_url'           => ['nullable', 'url'],
            'video_thumb'         => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'since_image'         => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'sections'            => ['nullable', 'array'],
            'sections.*.title'    => ['nullable', 'string', 'max:255'],
            'sections.*.position' => ['nullable', 'numeric'],
            'sections.*.page'     => ['nullable', 'numeric',
                Rule::exists( 'pages', 'id' )],
        ];
    }
}
