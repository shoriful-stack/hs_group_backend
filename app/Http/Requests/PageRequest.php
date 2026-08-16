<?php

namespace App\Http\Requests;

use App\Enums\PageStatus;
use App\Enums\Status;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class PageRequest extends FormRequest {
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
            'branch_id'       => ['nullable', 'exists:branches,id'],
            'language_id'     => ['nullable', 'exists:languages,id'],
            'title'           => ['required', 'string', 'max:255'],
            'content'         => ['nullable', 'string'],
            'main_image'      => ['nullable', 'max:2048'],
            'sub_image'       => ['nullable', 'max:2048'],
            'seo_title'       => ['nullable', 'string', 'max:255'],
            'seo_description' => ['nullable', 'string'],
            'seo_keywords'    => ['nullable', 'string'],
            'serial_no'       => ['nullable', 'integer', 'min:1'],
            'status'          => [new Enum( PageStatus::class )],
        ];
    }
}
