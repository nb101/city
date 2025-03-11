<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CityAnswerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'country' => 'required|string|max:255',
            'capital' => 'required|string|max:255'
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'country.required' => 'A country is required.',
            'capital.required' => 'A capital is required.'
        ];
    }
}
