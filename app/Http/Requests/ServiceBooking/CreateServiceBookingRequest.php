<?php

namespace App\Http\Requests\ServiceBooking;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Tymon\JWTAuth\Facades\JWTAuth;

class CreateServiceBookingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $user = JWTAuth::parseToken()->authenticate();
        return $user ? true : false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'service_id'=> 'required|string|exists:service_types,id',
            'message'   => 'nullable|string|max:255 ',
        ];
    }
    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json([
                'status'  => 'failed',
                'message' => 'Validation failed. Please check your input.',
                'errors'  => $validator->errors(),
            ], 422)
        );
    }
    public function attributes()
    {
        return [
            'service_id' => 'Service ID' ,
            'message'   => 'Booking Message'
        ];
    }
    public function messages()
    {
        return [
            'service_id.required' => 'Please select service',
            'service_id.stirng'   => 'Service Id must be a string.',
            'service_id.exists'   => 'Service selected is invalid.',

            'message.max'         => 'The message may not be greater than 255 characters.'
        ];
    }
}
