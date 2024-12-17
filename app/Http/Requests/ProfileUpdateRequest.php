<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ProfileUpdateRequest extends FormRequest
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
            'name' => 'required|string|max:100',
            'lname' => 'required|string|max:100',
            'image' => 'image|max:2048',
            'address' => 'required|string|max:200',
            'city' => 'required|string',
            'state' => 'required|string',
            'country' => 'required|string',
            'postal_code' => 'required'
        ];
    }

    public function messages(): array
    {
        return [
            'name.max' => __('maximum_100_characters'),
            'name.string' => __('name_should_be_string'),
            'lname.required' => __('last_name_field_is_required'),
            'lname.max' => __('maximum_100_characters'),
            'lname.string' => __('name_should_be_string'),
            'image.image' => __('the_uploaded_file_must_be_an_image'),
            'image.max' => __('the_image_may_not_be_larger_than_2_MB'),
            'address.required' => __('the_address_field_is_required'),
            'address.max' => __('the_address_must_not_exceed_200_characters'),
            'city' => __('the_city_field_is_required'),
            'state' => __('the_state_field_is_required'),
            'country' => __('the_country_field_is_required'),
            'postal_code' => __('the_postal_code_field_is_required')
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
