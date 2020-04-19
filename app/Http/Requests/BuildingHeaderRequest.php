<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class BuildingHeaderRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'building_title' => 'required|string',
            'building_address' => 'required|string',
            'building_desc' => 'required|string',
            'building_lat_coordinate' => 'sometimes|required',
            'building_long_coordinate' => 'sometimes|required',
        ];
    }

    /**
     * Handle a failed validation attempt.
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function failedValidation(Validator $validator) { 
        throw new HttpResponseException(
            response()->json([
                'success' => false, 
                'desc' => $validator->errors()
            ], 422)
        ); 
    }
}
