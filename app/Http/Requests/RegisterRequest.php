<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|max:255',
            'mobile' => 'required|unique:users,mobile|regex:/^(\+?\d{1,3}[- ]?)?\d{10}$/',
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'name',
            'mobile' => 'mobile number'
        ];
    }

    public function messages()
    {
        return [
            '*.required' => ':Attribute is required.',
            'mobile.unique' => ':Attribute exists',
            'mobile.regex' => 'Invalid format. Please enter a valid :attribute',
        ];
    }
}
