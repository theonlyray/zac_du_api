<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class LogInRequest extends FormRequest
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
            'correo' => 'required',
            'contrasenia' => 'required',
            'dispositivo' => 'sometimes',
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
