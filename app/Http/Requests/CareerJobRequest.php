<?php

namespace App\Http\Requests;

use App\Enums\Status;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class CareerJobRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title'                    => ['required', 'string', 'max:255'],
            'department'               => ['required', 'string', 'max:100'],
            'location'                 => ['required', 'string', 'max:255'],
            'type'                     => ['required', 'string', 'in:Full-time,Contract,Internship'],
            'experience'               => ['nullable', 'string', 'max:100'],
            'posted_at'                => ['required', 'date'],
            'application_deadline'     => ['nullable', 'date'],
            'vacancy'                  => ['required', 'integer', 'min:1'],
            'summary'                  => ['required', 'string'],
            'overview'                 => ['nullable', 'string'],
            'educational_qualifications' => ['nullable', 'string'],
            'experience_details'       => ['nullable', 'string'],
            'responsibilities'         => ['nullable', 'string'],
            'requirements'             => ['nullable', 'string'],
            'nice_to_have'             => ['nullable', 'string'],
            'benefits'                 => ['nullable', 'string'],
            'apply_email'              => ['nullable', 'email', 'max:255'],
            'contact_phones'           => ['nullable', 'string'],
            'application_instruction'  => ['nullable', 'string'],
            'image'                    => ['nullable', 'file', 'image', 'mimes:jpg,jpeg,png,svg,webp', 'max:2048'],
            'featured'                 => ['nullable', 'boolean'],
            'serial_no'                => ['required', 'numeric'],
            'status'                   => ['nullable', new Enum(Status::class)],
        ];
    }
}
