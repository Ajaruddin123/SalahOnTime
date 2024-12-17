<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class LoginWithMobileNumberRequest extends FormRequest
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
            'mobile_number' => 'required|regex:/^\d{10}$/',
            'password' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'mobile_number.required' => __('the_mobile_number_field_is_required'),
            'mobile_number.regex' => __('the_mobile_number_must_be_a_10_digit_number'),
            'password.required' => __('the_password_field_is_required')
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'status' => 'error',
            'message' => 'Validation failed',
            'errors' => $validator->errors(),
            'statusCode' => 422
        ], 422));
    }
}
