<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ResultRequest extends FormRequest
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
            'marks' => 'nullable|array|min:1',
            'marks.*' => 'nullable|numeric|between:0,10',
            'result_ids' => 'required|array|min:1',
        ];
    }
    public function messages()
    {
        return [
            'marks.array' => 'The mark is required',
            'marks.*.numeric' => 'The mark must be a number',
            'marks.*.between' => 'The mark must be between 0 and 10',
            'result_ids.required' => 'The result is invalid',
            'result_ids.array' => 'The result is invalid',
        ];
    }
}
