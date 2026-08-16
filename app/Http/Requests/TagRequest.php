<?php

namespace App\Http\Requests;

use App\Enums\Status;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

class TagRequest extends FormRequest {
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
            'name'        => ['required', 'string',
                Rule::unique( 'tags', 'name' )
                    ->where( fn( $query ) => $query->where( 'branch_id', Auth::user()->branch_id ) )
                    ->ignore( $this->tag )],
            'slug'        => ['nullable', 'string'],
            'serial_no'   => ['required', 'numeric'],
            'status'      => [new Enum( Status::class )],
        ];
    }
}
