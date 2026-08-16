<?php

namespace App\Http\Requests;

use App\Enums\Status;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

class AwardRequest extends FormRequest {
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
            'title'       => [
                'required',
                'string',
            ],
            'language_id' => ['nullable', 'numeric'],
            'contents'    => ['nullable', 'string'],
            'image'       => ['nullable', 'file', 'mimes:jpeg,jpg,png,webp', 'max:2024'],
            'status'      => [new Enum( Status::class )],
        ];
    }
}
