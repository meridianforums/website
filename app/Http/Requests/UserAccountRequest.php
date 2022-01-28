<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserAccountRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name'     => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', Rule::unique('users', 'username')->ignore(request()->user()->id)],
            'password' => ['nullable', 'sometimes', 'min:8', 'max:20', 'confirmed'],
            'email'    => ['required', 'string', 'email', 'max:255', Rule::unique('users', 'email')->ignore(request()->user()->id)],
        ];
    }
}
