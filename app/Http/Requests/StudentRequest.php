<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Carbon;

class StudentRequest extends FormRequest
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
         $rules =[
            'full_name' => 'required|string|max:255|regex:/^[a-zA-Z0-9]*$/',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
             'date_of_birth' => [
                 'required',
                 'date',
                 function ($attribute, $value, $fail) {
                     $today = now();
                     if ($value > $today) {
                         $fail('The date of birth must not be a future date.');
                     }
                     $dob = Carbon::createFromFormat('Y-m-d', $value);
                     if ($dob->age < 16) {
                         $fail('The person must be at least 16 years old.');
                     }
                 },
             ],
            'courses' => 'required|array|min:1',
            'courses.*' => 'integer|exists:courses,id',
            'department_id' => 'required|exists:departments,id',
        ];

        if ($this->isMethod('post')) {
            $rules['password'] = 'required|string|min:8|max:16';
            $rules['email'] = 'required|unique:users|email|max:255';

        } else {
            $rules['password'] = 'nullable|string|min:8|max:16';
            $rules['email'] = 'required|email|max:255';
        }

        return $rules;

    }
    public function messages()
    {
        return [
            'full_name.required' => 'Full name is required',
            'full_name.string' => 'Full name must be a string',
            'full_name.max' => 'Full name must not exceed 255 characters',
            'full_name.regex' => 'Full name cannot contain special characters',
            'email.required' => 'Email is required',
            'email.email' => 'Invalid email format',
            'email.max' => 'Email must not exceed 255 characters',
            'email.unique' => 'Email already exit',
            'password.required' => 'Password is required',
            'password.string' => 'Password must be a string',
            'password.min' => 'Password must be at least 8 characters',
            'password.max' => 'Password must not exceed 16 characters',
            'avatar.image' => 'The uploaded file must be an image.',
            'avatar.mimes' => 'The uploaded file must be a jpeg, png, jpg, or gif image.',
            'avatar.max' => 'The uploaded file may not be greater than 2MB in size.',
            'birth_date.required' => 'Birth date is required',
            'birth_date.date' => 'Birth date must be a valid date',
            'courses.required' => 'At least one course must be selected',
            'courses.array' => 'The selected course is invalid',
            'courses.min' => 'At least one course must be selected',
            'courses.*.integer' => 'The selected course is invalid',
            'courses.*.exists' => 'The selected course is invalid',
            'department_id.required' => 'Department is required',
            'department_id.exists' => 'Selected department does not exist',
        ];
    }
}
