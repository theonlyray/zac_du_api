<?php

namespace App\Http\Requests\Duty;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateDutyRequest extends FormRequest
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
            'descripcion'           => 'required|filled|string',
            'clave'                 => 'required|filled|string',
            'unidad'                => 'required|filled|string',
            'precio'                => 'required|filled|numeric',
            'activo'                => 'required|filled|boolean'
        ];
    }

    public function messages()
    {
        return [
            'filled' => 'El campo :attribute no debe estar vacío.',
            'email'  => 'El campo :attribute debe ser un email válido.',
            'string' => 'El campo :attribute debe ser una cadena de texto válida.',
            'unique' => 'El :attribute ya está asociado a otro registro.',
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
