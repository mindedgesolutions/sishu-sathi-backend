<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChildDetailsRequest extends FormRequest
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
            'below_18_above_35' => 'required|boolean',
            'medical_condition' => 'required|boolean',
            'take_suppliments' => 'required|boolean',
            'complications_pregnancy' => 'required|boolean',
            'assisted_delivery' => 'required|boolean',
            'hospital_born' => 'required|boolean',
            'before_37' => 'required|boolean',
            'less_than_two_and_half' => 'required|boolean',
            'apgar_below_7' => 'required|boolean',
            'complications_birth' => 'required|boolean',
            'cry_at_birth' => 'required|boolean',
            'delay_time' => 'nullable|required_if:cry_at_birth,delayed',
            'nicu_stay' => 'required|boolean',
            'breastfeeding_within_1' => 'required|boolean',
            'jaundice_other' => 'required|boolean',
            'hospitalised_year_1' => 'required|boolean',
            'seizures' => 'required|boolean',
        ];
    }

    public function messages()
    {
        return [
            'below_18_above_35.required' => 'Choose if the mother is below 18 or above 35 years old during pregnancy',
            'medical_condition.required' => 'Choose if the mother has any medical conditions',
            'take_suppliments.required' => 'Choose if the mother takes regular supplements',
            'complications_pregnancy.required' => 'Choose if there were any complications during pregnancy',
            'assisted_delivery.required' => 'Choose if the delivery a C-section or assisted',
            'hospital_born.required' => 'Choose if the child was born at a hospital',
            'before_37.required' => 'Choose if the baby born was before 37 weeks',
            'less_than_two_and_half.required' => 'Choose if the birth weight is less than 2.5 kg',
            'apgar_below_7.required' => 'Choose if the APGAR score was below 7',
            'complications_birth.required' => 'Choose if there were any complications during birth',
            'cry_at_birth.required' => 'Cry at birth is required.',
            'delay_time.required' => 'Delay time is required.',
            'nicu_stay.required' => 'Choose if the baby stay in NICU',
            'breastfeeding_within_1.required' => 'Choose if breastfeeding started within 1 hour of birth',
            'jaundice_other.required' => 'Choose if the baby had jaundice or any infections after birth',
            'hospitalised_year_1.required' => 'Choose if the baby was hospitalized in the first year',
            'seizures.required' => 'Choose if the baby ever had neonatal seizures or episodic seizures',
        ];
    }
}
