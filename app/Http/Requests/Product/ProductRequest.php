<?php

namespace App\Http\Requests\Product;

use App\Enums\Status;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class ProductRequest extends FormRequest
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
            'title'        => ['required', 'string'],
            'subtitle'  => ['nullable', 'string'],
            'description'  => ['nullable', 'string'],
            'overview_titles.*' => ['nullable', 'string'],
            'technical_specifications'  => ['nullable', 'string'],
            'application_titles.*' => ['nullable', 'string'],
            'feature_titles.*' => ['nullable', 'string'],
            'product_documents.*' => ['nullable', 'file', 'mimes:pdf,doc,docx,xlsx,ppt,pptx'],
            'documents_description.*' => ['nullable', 'string'],
            'documents_title.*' => ['nullable', 'string'],
            'documents_link.*' => ['nullable', 'string'],
            'category_id' => ['nullable', 'numeric'],
            'product_images.*' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp'],
            'seo_title'     => ['nullable', 'string'],
            'seo_description' => ['nullable', 'string'],
            'seo_keywords'   => ['nullable', 'string'],
        ];
    }
}
