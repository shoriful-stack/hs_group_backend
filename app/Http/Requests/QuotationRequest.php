<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class QuotationRequest extends FormRequest {
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
            'name'    => ['required', 'string', 'max:255'],
            'company'    => ['required', 'string', 'max:255'],
            'email'   => ['required', 'email'],
            'phone'   => ['nullable', 'string', 'max:20'],
            'product_id' => ['nullable', 'integer', 'exists:products,id'],
            'project_location' => ['required', 'string'],
            'timeline' => ['nullable', 'string'],
            'budget' => ['nullable', 'string'],
            'requirements' => ['required', 'string'],
        ];
    }
}
