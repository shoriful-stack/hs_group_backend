<?php

namespace App\Http\Requests;

use App\Enums\Status;
use App\Enums\YesNo;
use App\Models\Language;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

class LanguageRequest extends FormRequest {
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
            'name'       => ['required', 'string', 'max:50', Rule::unique(Language::class, 'name')->ignore($this->language)],
            'code'       => ['required', 'string', 'max:4', Rule::unique(Language::class, 'code',)->ignore($this->language)],
            'direction'  => ['nullable', 'in:ltr,rtl'],
            'is_default' => [new Enum(YesNo::class)],
            'status'     => [new Enum( Status::class )],
        ];
    }
}
