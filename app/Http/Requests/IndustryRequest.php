<?php

namespace App\Http\Requests;

use App\Enums\Status;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class IndustryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title'     => ['required', 'string', 'max:255'],
            'contents'  => ['nullable', 'string'],
            'icon'      => ['nullable', 'string', 'max:100'],
            'serial_no' => ['required', 'numeric'],
            'status'    => ['nullable', new Enum(Status::class)],
        ];
    }
}
