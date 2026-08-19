<?php

namespace App\Http\Requests\Blog;

use App\Enums\Status;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class BlogCategoryRequest extends FormRequest {
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
            'name'            => ['required','string'],
            'status'          => ['nullable', new Enum( Status::class )],
            'serial_no'       => ['required', 'string'],
            'seo_title'       => ['nullable', 'string'],
            'seo_description' => ['nullable', 'string'],
            'seo_keywords'    => ['nullable', 'string'],
        ];
    }
}
