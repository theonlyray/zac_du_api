<?php

namespace App\Http\Requests\Requirement;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateRequirementRequest extends FormRequest
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
            'nombre'            => 'nullable|required|filled|string',
            'nota'              => 'nullable|sometimes|string',
            'descripcion'       => 'nullable|sometimes|string',
            'activo'            => 'nullable|required|filled|boolean',
            'obligatorio'       => 'nullable|required|filled|boolean',
            'es_plano'          => 'nullable|required|filled|boolean',
            'license_type_id'   => 'nullable|required|filled|int|exists:license_types,id',
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
