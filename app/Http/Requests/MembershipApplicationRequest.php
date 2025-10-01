<?php

namespace App\Http\Requests;

use App\Models\MemberProfile;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MembershipApplicationRequest extends FormRequest
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
            // first_name, last_name, email removed - taken from authenticated user
            'phone' => ['nullable', 'string', 'max:20'],
            'cpr_number' => ['required', 'string', 'size:9', 'regex:/^\d{9}$/', 'unique:member_profiles,cpr_number'],
            'staff_number' => ['required', 'string', 'max:50', 'unique:member_profiles,staff_number'],
            'nationality' => ['required', 'string', Rule::in(array_keys(MemberProfile::getNationalityOptions()))],
            'gender' => ['required', 'string', Rule::in(array_keys(MemberProfile::getGenderOptions()))],
            'marital_status' => ['required', 'string', Rule::in(array_keys(MemberProfile::getMaritalStatusOptions()))],
            'date_of_joining' => ['required', 'date'],
            'position' => ['required', 'string', 'max:255'],
            'department' => ['required', 'string', 'max:255'],
            'section' => ['nullable', 'string', 'max:255'],
            'working_place_address' => ['required', 'string'],
            'office_phone' => ['nullable', 'string', 'max:20'],
            'education_qualification' => ['required', 'string', Rule::in(array_keys(MemberProfile::getEducationQualificationOptions()))],
            'mobile_number' => ['required', 'string', 'max:20'],
            'home_phone' => ['nullable', 'string', 'max:20'],
            'permanent_address' => ['required', 'string'],
            'employee_image' => ['required', 'file', 'image', 'mimes:jpg,jpeg,png,gif', 'max:10240'], // 10MB max
            'signature' => ['required', 'file', 'image', 'mimes:jpg,jpeg,png,gif', 'max:5120'], // 5MB max
            'withdrawal_letter' => ['nullable', 'file', 'mimes:pdf,doc,docx,jpg,jpeg,png', 'max:5120'], // 5MB max
            'was_previous_member' => ['required', 'string', 'in:yes,no'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'cpr_number.required' => 'CPR number is required.',
            'cpr_number.size' => 'CPR number must be exactly 9 digits.',
            'cpr_number.regex' => 'CPR number must contain only digits.',
            'cpr_number.unique' => 'This CPR number is already registered.',
            'staff_number.required' => 'Staff number is required.',
            'staff_number.unique' => 'This staff number is already registered.',
            'email.unique' => 'This email address is already registered.',
            'employee_image.required' => 'Employee image is required.',
            'employee_image.image' => 'The uploaded file must be an image.',
            'employee_image.mimes' => 'Employee image must be a file of type: jpg, jpeg, png, gif.',
            'employee_image.max' => 'Employee image may not be greater than 10MB.',
            'signature.required' => 'Digital signature is required.',
            'signature.image' => 'The signature must be an image.',
            'signature.mimes' => 'Signature must be a file of type: jpg, jpeg, png, gif.',
            'signature.max' => 'Signature may not be greater than 5MB.',
        ];
    }
}
