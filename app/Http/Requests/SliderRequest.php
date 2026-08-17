<?php

namespace App\Http\Requests;

use App\Enums\Status;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class SliderRequest extends FormRequest {
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
            'title'       => ['required', 'string'],
            'language_id' => ['nullable', 'numeric'],
            'contents'    => ['nullable', 'string'],
            'sub_title'   => ['nullable', 'string'],
            'sub_content' => ['nullable', 'string'],
            'image'       => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'video'       => ['nullable', 'file', 'mimetypes:video/mp4,video/webm,video/quicktime', 'max:51200'],
            'url'         => ['nullable', 'url'],
            'serial_no'   => ['required', 'numeric'],
            'status'      => [new Enum( Status::class )],
        ];
    }
}
