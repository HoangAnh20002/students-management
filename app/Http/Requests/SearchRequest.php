<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SearchRequest extends FormRequest
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
            'result_from' => 'nullable|numeric|min:0|max:10',
            'result_to' => 'nullable|numeric|min:0|max:10|',
            'age_from' => 'nullable|integer|min:0|max:150',
            'age_to' => 'nullable|integer|min:0|max:150|'
        ];
    }
    public function messages()
    {
        return [
            'age_from.integer' => 'The age from field must be an integer.',
            'age_from.min' => 'The age from must be at least 0.',
            'age_from.max' => 'The age from may not be greater than 150.',
            'age_to.integer' => 'The age to field must be an integer.',
            'age_to.min' => 'The age to must be at least 0.',
            'age_to.max' => 'The age to may not be greater than 150.',
            'result_from.integer' => 'The result from field must be an integer.',
            'result_from.min' => 'The result from must be at least 0.',
            'result_from.max' => 'The result from may not be greater than 10.',
            'result_to.integer' => 'The result to field must be an integer.',
            'result_to.min' => 'The result to must be at least 0.',
            'result_to.max' => 'The result to may not be greater than 10.',
        ];
    }
}
