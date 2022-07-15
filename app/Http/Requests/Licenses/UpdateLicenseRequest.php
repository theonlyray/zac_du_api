<?php

namespace App\Http\Requests\Licenses;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class UpdateLicenseRequest extends FormRequest
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
            'estatus'           => 'required|integer',
            // 'folio'             => 'required|string',
            'license_type_id'   => 'required|integer',

            'property'            => 'required|array',
            'property.calle'      => 'required|string',
            'property.no'         => 'required|string',
            'property.colonia'    => 'required|string',
            'property.seccion'    => 'sometimes|string',
            'property.manzana'    => 'sometimes|string',
            'property.lote'       => 'sometimes|string',
            'property.no_predial' => 'required|string',
            'property.clave_catastral'   => 'sometimes|string|nullable',
            'property.sup_terreno'       => 'sometimes|numeric',
            'property.sup_construida'    => 'sometimes|numeric',
            'property.sup_no_construida' => 'sometimes|numeric',
            'property.latitud'           => 'required|string',
            'property.longitud'          => 'required|string',

            'backgrounds'                      => ['sometimes','nullable','array'],
            // 'backgrounds.*.prior_license_id'   => 'nullable|integer|exists:licenses,id',
            'backgrounds.*.prior_license_id'   => 'nullable|string',
            'backgrounds.*.fecha'              => 'nullable|date',

            'construction'                           => [Rule::requiredIf($this->input('license_type_id') <= 2), 'filled'],
            'construction.sotano'                    => 'required|numeric|min:0',
            'construction.planta_baja'               => 'required|numeric|min:0',
            'construction.mezzanine'                 => 'required|numeric|min:0',
            'construction.primer_piso'               => 'required|numeric|min:0',
            'construction.segundo_piso'              => 'required|numeric|min:0',
            'construction.tercer_piso'               => 'required|numeric|min:0',
            'construction.cuarto_piso'               => 'required|numeric|min:0',
            'construction.quinto_piso'               => 'required|numeric|min:0',
            'construction.sexto_piso'                => 'required|numeric|min:0',
            'construction.descubierta'               => 'required|numeric|min:0',
            'construction.sup_total_amp_reg_const'   => 'required|numeric|min:1',
            'construction.descripcion'               => 'required|string',

            //?owner data is required for dros, if user is particular, the owner's data will be those of the user himself
            'owner'                   => 'required_if:propietario.ownerFlag,flase|array',
            'owner.nombre_apellidos'  => 'required|string',
            'owner.rfc'               => 'required|string',
            'owner.domicilio'         => 'required|string',
            'owner.ocupacion'         => 'required|string',
            'owner.telefono'          => 'required|string',

            'anuncio' => [Rule::requiredIf(self::isAd()), 'array', 'nullable'],
            'anuncio.colocacion'    => [Rule::requiredIf(self::isAd()), 'boolean'],
            'anuncio.tipo'          => [Rule::requiredIf(self::isAd()), 'string'],
            'anuncio.cantidad'      => 'integer|sometimes|nullable',
            'anuncio.largo'         => 'numeric|sometimes|min:0|nullable',
            'anuncio.ancho'         => 'numeric|sometimes|min:0|nullable',
            'anuncio.alto'          => 'numeric|sometimes|min:0|nullable',
            'anuncio.colores'       => 'string|sometimes|nullable',
            'anuncio.texto'         => 'string|sometimes|nullable',
            'anuncio.fecha_inicio'  => 'date|sometimes|nullable',
            'anuncio.fecha_fin'     => 'date|sometimes|nullable',

            'compatibilidad' => [Rule::requiredIf($this->input('license_type_id') == 16), 'array', 'nullable'],
            'compatibilidad.medidas_colindancia'    => 'string|sometimes|nullable',
            'compatibilidad.m2_ocupacion'           => 'numeric|sometimes|nullable',
            'compatibilidad.uso_actual'             => 'string|sometimes|nullable',
            'compatibilidad.uso_propuesto'          => 'string|sometimes|nullable',

            'sfd' => [Rule::requiredIf($this->input('license_type_id') == 22), 'array', 'nullable'],
            'sfd.descripcion'               => 'string|sometimes|nullable',
            'sfd.medidas_colindancia'       => 'string|sometimes|nullable',
            'compatibilidad.m2_ocupacion'   => 'numeric|sometimes|nullable',

            'validity'                      => 'sometimes|nullable',
            'validity.fecha_autorizacion'   => 'sometimes|date|nullable',
            'validity.fecha_fin_vigencia'   => 'sometimes|date|nullable',
            'validity.dias_total'           => 'sometimes|int|nullable',
        ];
    }

    /**
     *  check if license is a construction
     */
    public function isConstruction()
    {
        return $this->input('license_type_id') >= 1 && $this->input('license_type_id') <= 3;
    }

    /**
     * check if license is an ad
     */
    public function isAd()
    {
        return $this->input('license_type_id') >= 17 && $this->input('license_type_id') <= 20;
    }

    public function messages()
    {
        return [
            'required' => 'El campo :attribute es requerido',
            'string' => 'El campo :attribute debe ser un texto válido.',
            'integer' => 'El campo :attribute debe ser un número entero.',
            'date' => 'El campo :attribute debe ser una fecha válida.',
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
