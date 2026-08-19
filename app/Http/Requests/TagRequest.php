<?php

namespace App\Http\Requests;

use App\Enums\Status;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

class TagRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'      => [
                'required',
                'string',
                'max:255',
                Rule::unique('tags', 'name')
                    ->where(fn($query) => $query
                        ->where('branch_id', Auth::user()->branch_id)
                        ->whereNull('deleted_at'))
                    ->ignore($this->route('tag')),
            ],
            'serial_no' => ['required', 'numeric'],
            'status'    => ['nullable', new Enum(Status::class)],
        ];
    }
}
