<?php

namespace App\Http\Requests\LandUse;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateLandUseRequest extends FormRequest
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
            'nombre' => 'string|required',
            // 'descriptions'                  => 'required',
            // 'descriptions.*.id'             => 'sometimes|id',
            // 'descriptions.*.descripcion'    => 'required|string',
            // 'descriptions.*.uma'            => 'required|numeric',
            // 'descriptions.*.land_use_id'    => 'required|exists:land_uses,id',
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
