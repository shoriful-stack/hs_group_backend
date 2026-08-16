<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ServiceRequest extends FormRequest
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
            'category_id' => ['required', 'exists:service_categories,id'],
            'title' => ['required', 'string', 'max:255'],
            'subtitle' => ['nullable', 'string'],
            'description' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp'],

            'seo_title' => ['nullable', 'string', 'max:255'],
            'seo_keywords' => ['nullable', 'string'],
            'seo_description' => ['nullable', 'string'],

            'highlights_title.*' => ['nullable', 'string'],
            'highlights_value.*' => ['nullable', 'string'],
            
            'benefits_title.*' => ['nullable', 'string'],
            'benefits_icon.*' => ['nullable', 'string'],
            'benefits_description.*' => ['nullable', 'string'],

            'scope_step.*' => ['nullable', 'integer'],
            'scope_title.*' => ['nullable', 'string'],
            'scope_description.*' => ['nullable', 'string'],
            
            'capabilities_title.*' => ['nullable', 'string'],
            'capabilities_value.*' => ['nullable', 'string'],

            'process_serial.*' => ['nullable', 'integer'],
            'process_title.*' => ['nullable', 'string'],
            'process_description.*' => ['nullable', 'string'],

            'service_equipment_category_id.*' => ['nullable', 'exists:service_equipment_categories,id'],
            'equipment_items.*' => ['nullable', 'string'],
        ];
    }
}
