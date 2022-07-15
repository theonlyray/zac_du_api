<?php

namespace App\Http\Requests\Property;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdatePropertyRequest extends FormRequest
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
            'calle'             => 'required|string|filled',
            'no'                => 'required|filled|string',
            'colonia'           => 'required|string|filled',
            'seccion'           => 'nullable|string',
            'manzana'           => 'nullable|string',
            'lote'              => 'nullable|string',
            'no_predial'        => 'nullable|string',
            'clave_catastral'   => 'required|filled|string',
            'sup_terreno'       => 'required|numeric|filled',
            'sup_construida'    => 'required|numeric|filled',
            'sup_no_construida' => 'required|numeric|filled',
            'latitud'           => 'sometimes|numeric|filled',
            'longitud'          => 'sometimes|numeric|filled',
            'doc_key'           => 'sometimes|string|in:mapa,croquis,escrituras,predial,fachada,panoramica',
            'doc_value'         => 'sometimes|string',
        ];
    }

    public function messages()
    {
        return [
            'required' => 'El campo :attribute es requerido',
            'string' => 'El campo :attribute debe ser un texto válido.',
            'integer' => 'El campo :attribute debe ser un número entero.',
            'numeric' => 'El campo :attribute debe ser un número válido.',
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
