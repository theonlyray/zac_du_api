<?php

namespace App\Http\Requests\Files;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreFileRequest extends FormRequest
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
            'para'          => 'required|boolean|nullable',
            'college_id'    => 'nullable',
            'archivo'       => 'required|string',
            'nombre'        => 'required|string',
        ];
    }

    public function messages()
    {
        return [
            'exists'        => 'El campo :attribute no existe.',
            'required'      => 'El campo :attribute es requerido',
            'string'        => 'El campo :attribute debe ser un texto válido.',
            'integer'       => 'El campo :attribute debe ser un número entero.',
            'date'          => 'El campo :attribute debe ser una fecha válida.',
            'numeric'       => 'El campo :attribute debe ser un número válido.',
            'min'           => 'El campo :attribute debe tener un valor mínimo de :min.',
            'required_if'   => 'El campo :attribute es requerido cuando :other es :value',
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
