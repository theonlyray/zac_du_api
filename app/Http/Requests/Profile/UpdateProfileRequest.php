<?php

namespace App\Http\Requests\Profile;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateProfileRequest extends FormRequest
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
            'nombre'        => 'required|string',
            'correo'        => 'required|email',
            'contrasenia'   => 'sometimes|filled|string',
            'ccontrasenia'  => 'sometimes|filled|string|same:contrasenia',

            'applicant_details.celular'     => 'sometimes|filled|string',
            'applicant_details.rfc'         => 'sometimes|filled|string',
            'applicant_details.no_registro' => 'sometimes|filled|string',
            'applicant_details.calle'       => 'sometimes|filled|string',
            'applicant_details.no'          => 'sometimes|filled|string',
            'applicant_details.colonia'     => 'sometimes|filled|string',
            'applicant_details.cp'          => 'sometimes|filled|string',
        ];
    }

    /**
     * Custom messages for validation rules
     *
     * @return array
     */
    public function messages()
    {
        return ['required' => 'El campo :attribute es requerido'];
    }

    protected function failedValidation(Validator $validator)
    {
        $message = "";

        foreach ($validator->errors()->all() as $field) {
            $message = $message . $field . "\n";
        }

        throw new HttpResponseException(response()->json(['message' => $message], 422));
    }
}
