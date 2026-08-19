<?php

namespace App\Http\Requests\Blog;

use App\Enums\Status;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class BlogAuthorRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'         => ['required', 'string', 'max:255'],
            'designation'  => ['nullable', 'string', 'max:255'],
            'department'   => ['nullable', 'string', 'max:255'],
            'bio'          => ['nullable', 'string'],
            'linkedin'     => ['nullable', 'string', 'max:255'],
            'email'        => ['nullable', 'email', 'max:255'],
            'photo'        => ['nullable', 'file', 'image', 'mimes:jpg,jpeg,png,svg,webp', 'max:2048'],
            'serial_no'    => ['required', 'numeric'],
            'status'       => ['nullable', new Enum(Status::class)],
        ];
    }
}
