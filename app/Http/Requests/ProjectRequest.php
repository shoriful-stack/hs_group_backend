<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProjectRequest extends FormRequest
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
            'category_id' => ['required', 'exists:project_categories,id'],
            'customer_id' => ['required', 'exists:our_customers,id'],
            'location' => ['required', 'string', 'max:255'],
            'year' => ['required', 'string', 'max:255'],
            'duration' => ['required', 'string', 'max:255'],
            'project_value' => ['required', 'string', 'max:255'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp'],

            'seo_title' => ['nullable', 'string', 'max:255'],
            'seo_keywords' => ['nullable', 'string'],
            'seo_description' => ['nullable', 'string'],

            'highlights_title.*' => ['nullable', 'string'],
            'highlights_value.*' => ['nullable', 'string'],

            'informations_title.*' => ['nullable', 'string'],
            'informations_icon.*' => ['nullable', 'string'],
            'informations_description.*' => ['nullable', 'string'],

            'scope_step.*' => ['nullable', 'integer'],
            'scope_title.*' => ['nullable', 'string'],
            'scope_description.*' => ['nullable', 'string'],

            'type.*' => ['nullable', 'string'],
            'challenge_description.*' => ['nullable', 'string'],

            'project_equipment_category_id.*' => ['nullable', 'exists:project_equipment_categories,id'],
            'equipment_items.*' => ['nullable', 'string'],

            'project_images.*' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp'],

            'impacts_title.*' => ['nullable', 'string'],
            'impacts_value.*' => ['nullable', 'string'],

            'reviews_department.*' => ['nullable', 'string'],
            'reviews_designation.*' => ['nullable', 'string'],
            'reviews_description.*' => ['nullable', 'string'],

            'question' => ['nullable', 'string'],
            'answer' => ['nullable', 'string'],
        ];
    }
}
