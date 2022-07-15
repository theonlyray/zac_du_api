<?php

namespace App\Http\Requests\Requirement;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreRequirementRequest extends FormRequest
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
            'nombre'            => 'required|filled|string',
            'nota'              => 'sometimes|string',
            'descripcion'       => 'sometimes|string',
            'activo'            => 'required|filled|boolean',
            'obligatorio'       => 'required|filled|boolean',
            'es_plano'          => 'required|filled|boolean',
            'license_type_id'   => 'required|filled|int|exists:license_types,id',
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
