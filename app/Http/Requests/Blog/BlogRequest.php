<?php

namespace App\Http\Requests\Blog;

use App\Enums\BlogStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class BlogRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'author_id'    => $this->author_id === '' ? null : $this->author_id,
            'reading_time' => $this->reading_time === '' ? null : $this->reading_time,
        ]);
    }

    public function rules(): array
    {
        return [
            'title'           => ['required', 'string'],
            'excerpt'         => ['nullable', 'string'],
            'summary'         => ['nullable', 'string'],
            'language_id'     => ['nullable', 'numeric'],
            'status'          => ['nullable', new Enum(BlogStatus::class)],
            'category_id'     => ['nullable', 'numeric'],
            'author_id'       => ['nullable', 'numeric', 'exists:blog_authors,id'],
            'tag_id'          => ['nullable', 'array'],
            'tag_id.*'        => ['numeric'],
            'contents'        => ['required', 'string'],
            'image'           => ['nullable', 'file', 'image', 'mimes:jpg,jpeg,png,svg,webp', 'max:2048'],
            'pdf_file'        => ['nullable', 'file', 'mimes:pdf', 'max:10240'],
            'featured'        => ['nullable', 'boolean'],
            'reading_time'    => ['nullable', 'integer', 'min:1', 'max:60'],
            'published_at'    => ['nullable', 'date'],
            'seo_title'       => ['nullable', 'string'],
            'seo_description' => ['nullable', 'string'],
            'seo_keywords'    => ['nullable', 'string'],
            'serial_no'       => ['required', 'numeric'],
        ];
    }
}
