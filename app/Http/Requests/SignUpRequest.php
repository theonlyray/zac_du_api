<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class SignUpRequest extends FormRequest
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
            'nombre'          => 'required|filled|string',
            'correo'          => 'required|email|unique:users,correo',
            'contrasenia'     => 'required|filled|string',
            'ccontrasenia'    => 'same:contrasenia|filled|string',
            'celular'         => 'required|filled|string|min:10|max:10',
            'rfc'             => 'required|filled|string',
            'no_registro'     => 'sometimes|filled|string|unique:applicant_data,no_registro',
            'calle'           => 'required|filled|string',
            'no'              => 'required|filled|string',
            'colonia'         => 'required|filled|string',
            'cp'              => 'required|filled|string|max:5|min:5',
            'role_id'         => 'required|filled|int',
            'college_id'      => 'required_if:role_id,8|filled|int|exists:colleges,id',
            'ocupacion'       => 'required_if:role_id,9|filled|string',
            'dispositivo'     => 'sometimes|string',
        ];
    }

    public function messages()
    {
        return [
            'required'  => 'El campo :attribute es requerido.',
            'filled'    => 'El campo :attribute no debe estar vacío.',
            'email'     => 'El campo :attribute debe ser un email válido.',
            'string'    => 'El :attribute debe ser un texrto válido.',
            'unique'    => 'El :attribute ya está asociado a otro usuario.',
            'confirmed' => 'Las :attribute no coinciden.',
            'same'      => 'Las contraseñas no coinciden.',
        ];
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
