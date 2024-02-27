<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
        return [
            'name' => 'required|string|max:255|regex:/^[a-zA-Z0-9]*$/',
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required|string|min:8|max:16',
            'student_code' => 'required|string|min:6|max:12',
            'image' => 'nullable|ends_with:.jpg,.png',
            'birth_date' => 'required|date',
            'courses' => 'required|array|min:1',
            'courses.*' => 'integer|exists:departments,id',
            'department_id' => 'required|exists:departments,id',
        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'Name is required',
            'name.string' => 'Name must be a string',
            'name.max' => 'Name must not exceed 255 characters',
            'name.regex' => 'Name cannot contain special characters',
            'full_name.required' => 'Full name is required',
            'full_name.string' => 'Full name must be a string',
            'full_name.max' => 'Full name must not exceed 255 characters',
            'email.required' => 'Email is required',
            'email.email' => 'Invalid email format',
            'email.max' => 'Email must not exceed 255 characters',
            'email.unique' => 'Email has been selected',
            'password.required' => 'Password is required',
            'password.string' => 'Password must be a string',
            'password.min' => 'Password must be at least 8 characters',
            'password.max' => 'Password must not exceed 16 characters',
            'student_code.required' => 'Student code is required',
            'student_code.string' => 'Student code must be a string',
            'student_code.min' => 'Student code must be at least 8 characters',
            'student_code.max' => 'Student code must not exceed 16 characters',
            'image.ends_with' => 'Image must be a .jpg or .png file',
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
