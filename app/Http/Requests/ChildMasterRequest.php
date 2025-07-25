<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Date;

class ChildMasterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function prepareForValidation()
    {
        $this->merge([
            'dob' => Date::createFromFormat('d/m/Y', $this->dob)
        ]);
    }

    public function rules(): array
    {
        return [
            'name' => 'required|max:255',
            'dob' => 'required|date|before:today',
            'gender' => 'required|in:male,female,other',
            'blood_group' => 'nullable|in:A+,A-,B+,B-,O+,O-,AB+,AB-',
            'relationship' => 'nullable',
            'mobile' => 'nullable|regex:/^(\+?\d{1,3}[- ]?)?\d{10}$/',
            'weight' => 'nullable',
            'file' => 'nullable|file|mimes:jpg,jpeg,png,webp|max:200',
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'child name',
            'dob' => 'date of birth',
            'gender' => 'gender',
            'blood_group' => 'blood group',
            'relationship' => 'relationship',
            'mobile' => 'mobile number',
            'weight' => 'weight',
            'file' => 'profile image',
        ];
    }

    public function messages()
    {
        return [
            '*.required' => ':Attribute is required',
            '*.max' => ':Attribute must not be more than :max characters',
            'dob.date' => 'Invalid date format',
            'dob.before' => 'Date of birth must be before today',
            'mobile.regex' => 'Invalid format. Please enter a valid mobile number',
            'file.mimes' => 'Profile image must be a file of type: jpg, jpeg, png, webp',
            'file.max' => 'Profile image may not be greater than 200 KB',
        ];
    }
}
