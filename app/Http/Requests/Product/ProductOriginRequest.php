<?php

namespace App\Http\Requests\Product;

use App\Enums\Status;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

class ProductOriginRequest extends FormRequest {
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
            'language_id' => ['nullable', 'numeric'],
            'name'        => ['required', 'string'],
            'slug'        => ['nullable', 'string'],
            'serial'      => ['required', 'numeric'],
            'status'      => [new Enum( Status::class )],
        ];
    }
}
