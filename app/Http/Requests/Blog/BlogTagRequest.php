<?php

namespace App\Http\Requests\Blog;

use App\Enums\Status;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class BlogTagRequest extends FormRequest
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
            'branch_id' => ['nullable', 'numeric'],
            'language_id' => ['nullable', 'numeric'],
            'status' => [new Enum(Status::class)],
            'blog_id' => ['required', 'numeric'],
            'tag_id' => ['required', 'numeric'],
            'serial_no' => ['nullable', 'numeric'],
        ];
    }
}
