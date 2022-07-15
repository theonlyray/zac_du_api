<?php

namespace App\Http\Requests\Profile;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateSpecialtiesRequest extends FormRequest
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
             'especialidades'                   => 'bail|required|array',
             'especialidades.*.speciality_id'   => 'bail|required|int',
             'especialidades.*.no_registro'     => 'bail|required|string',
             'especialidades.*.validado'        => 'bail|required|boolean',
        ];
    }

    /**
     * Custom messages for validation rules
     *
     * @return array
     */
    public function messages()
    {
        return [
            'required'  => 'El campo :attribute es requerido',
            'int'       => 'El campo :attribute debe ser un no. entero',
            'validado'  => 'El campo :attribute debe ser un booleano',
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
