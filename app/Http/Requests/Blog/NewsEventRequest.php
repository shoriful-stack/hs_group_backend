<?php

namespace App\Http\Requests\Blog;

use App\Enums\Status;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class NewsEventRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title'      => ['required', 'string', 'max:255'],
            'event_date' => ['required', 'date'],
            'location'   => ['required', 'string', 'max:255'],
            'image'      => ['nullable', 'file', 'image', 'mimes:jpg,jpeg,png,svg,webp', 'max:2048'],
            'cta_label'  => ['nullable', 'string', 'max:255'],
            'cta_href'   => ['nullable', 'string', 'max:255'],
            'serial_no'  => ['required', 'numeric'],
            'status'     => ['nullable', new Enum(Status::class)],
        ];
    }
}
