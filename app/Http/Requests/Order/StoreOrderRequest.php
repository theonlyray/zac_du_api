<?php

namespace App\Http\Requests\Order;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreOrderRequest extends FormRequest
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
            'derechos'              => 'required|filled|array',
            'derechos.*.id'         => 'required|filled|integer|exists:duties,id',
            'derechos.*.cantidad'   => 'required|filled|numeric',
        ];
    }

    public function messages()
    {
        return [
            'filled' => 'El campo :attribute no debe estar vacío.',
            'exists' => 'El campo :attribute no debe ser un derecho existente.',
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
