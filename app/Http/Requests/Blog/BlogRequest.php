<?php

namespace App\Http\Requests\Blog;

use App\Enums\BlogStatus;
use App\Models\Blog;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

class BlogRequest extends FormRequest {
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
            'title'           => ['required', 'string'],
            'language_id'     => ['nullable', 'numeric'],
            'status'          => ['nullable', new Enum( BlogStatus::class )],
            'category_id'     => ['nullable', 'numeric'],
            'contents'        => ['required', 'string'],
            'image'           => ['nullable', 'file', 'image', 'mimes:jpg,jpeg,png,svg,webp', 'max:2048'],
            'seo_title'       => ['nullable', 'string'],
            'seo_description' => ['nullable', 'string'],
            'seo_keywords'    => ['nullable', 'string'],
            'serial_no'       => ['required', 'string'],
        ];
    }
}
