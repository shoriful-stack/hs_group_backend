<?php

namespace App\Http\Requests;

use App\Enums\Status;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class MessagingRequest extends FormRequest
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
            'icon'      => ['required', 'string', 'max:255'],
            'link'      => ['required', 'string', 'max:255'],
            'serial_no' => ['required', 'numeric'],
            'status'    => [new Enum(Status::class)],
        ];
    }
}
