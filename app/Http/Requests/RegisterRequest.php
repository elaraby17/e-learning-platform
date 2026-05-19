<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class RegisterRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255|min:3',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|starts_with:010,011,012,015',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'bio' => 'nullable|string|max:1000|min:10',
            'gender' => 'nullable|in:male,female',
            'password' => ['required',Password::default(),'confirmed'],
        ];
    }
}
