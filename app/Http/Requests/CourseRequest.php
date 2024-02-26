<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CourseRequest extends FormRequest
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
            'departments' => 'required|array|min:1',
            'departments.*' => 'integer|exists:departments,id',
        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'Name is required',
            'name.string' => 'Name must be a string',
            'name.max' => 'Name must not exceed 255 characters',
            'name.regex' => 'Name cannot contain special characters',
            'departments.required' => 'At least one department must be selected',
            'departments.array' => 'The selected department is invalid',
            'departments.min' => 'At least one department must be selected',
            'departments.*.integer' => 'The selected department is invalid',
            'departments.*.exists' => 'The selected department is invalid',
        ];
    }
}
