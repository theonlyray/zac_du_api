<?php

namespace App\Http\Requests\Licenses;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreLicenseObservationRequest extends FormRequest
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
            'estatus'     => 'required|filled|int|max:16',
            'observacion' => 'required|filled|string',
            'contrasenia' => 'required_if:estatus,>=,15|string|filled',
            'file'        => 'required_if:estatus,==,8|nullable',
        ];
    }

    public function messages()
    {
        return [
            'required' => 'El campo :attribute es requerido',
            'string' => 'El campo :attribute debe ser un texto válido.',
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
