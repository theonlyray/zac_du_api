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

            'property'            => 'sometimes|array|nullable',
            'property.calle'      => 'sometimes|string|nullable',
            'property.no'         => 'sometimes|string|nullable',
            'property.colonia'    => 'sometimes|string|nullable',
            'property.seccion'    => 'sometimes|string|nullable',
            'property.manzana'    => 'sometimes|string|nullable',
            'property.lote'       => 'sometimes|string|nullable',
            'property.no_predial' => 'sometimes|string|nullable',
            'property.clave_catastral'   => 'sometimes|string|nullable',
            'property.sup_terreno'       => 'sometimes|numeric|nullable',
            'property.sup_construida'    => 'sometimes|numeric|nullable',
            'property.sup_no_construida' => 'sometimes|numeric|nullable',
            'property.latitud'           => 'sometimes|string|nullable',
            'property.longitud'          => 'sometimes|string|nullable',

            'backgrounds'                      => ['array', 'nullable'],
            // 'backgrounds'                      => ['array', 'nullable', Rule::requiredIf(self::isConstruction()),],
            'backgrounds.data.*.prior_license_id'           =>
                [Rule::requiredIf(is_null($this->input('backgrounds.data.*.physical_prior_license_id'))),'nullable','integer','exists:licenses,id'],//? digital background
            'backgrounds.data.*.physical_prior_license_id'  =>
                [Rule::requiredIf(is_null($this->input('backgrounds.data.*.prior_license_id'))),'nullable','string'],//? physical background
            'backgrounds.data.*.fecha'  =>
                [Rule::requiredIf(is_null($this->input('backgrounds.data.*.prior_license_id'))),'nullable','date'],//?required if is physical background

            'construction'                           => [Rule::requiredIf(self::isConstruction()),'nullable','array'],
            'construction.sotano'                    => 'sometimes|numeric|min:0',
            'construction.planta_baja'               => 'sometimes|numeric|min:0',
            'construction.mezzanine'                 => 'sometimes|numeric|min:0',
            'construction.primer_piso'               => 'sometimes|numeric|min:0',
            'construction.segundo_piso'              => 'sometimes|numeric|min:0',
            'construction.tercer_piso'               => 'sometimes|numeric|min:0',
            'construction.cuarto_piso'               => 'sometimes|numeric|min:0',
            'construction.quinto_piso'               => 'sometimes|numeric|min:0',
            'construction.sexto_piso'                => 'sometimes|numeric|min:0',
            'construction.descubierta'               => 'sometimes|numeric|min:0',
            'construction.sup_total_amp_reg_const'   => 'sometimes|numeric|min:1',
            'construction.descripcion'               => 'sometimes|string',

            //?owner data is required for dros, if user is particular, the owner's data will be those of the user himself
            'owner'                   => [Rule::requiredIf(self::isConstruction()), 'array', 'nullable'],
            // 'owner'                   => 'required_if:propietario.ownerFlag,flase|array',
            'owner.nombre_apellidos'  => 'sometimes|string',
            'owner.rfc'               => 'sometimes|string',
            'owner.domicilio'         => 'sometimes|string',
            'owner.ocupacion'         => 'sometimes|string',
            'owner.telefono'          => 'sometimes|string',

            'ad' => [Rule::requiredIf(self::isAd()), 'array', 'nullable'],
            'ad.colocacion'    => [Rule::requiredIf(self::isAd()), 'string'],
            'ad.tipo'          => [Rule::requiredIf(self::isAd()), 'string'],
            'ad.cantidad'      => 'integer|sometimes|nullable',
            'ad.largo'         => 'numeric|sometimes|min:0|nullable',
            'ad.ancho'         => 'numeric|sometimes|min:0|nullable',
            'ad.alto'          => 'numeric|sometimes|min:0|nullable',
            'ad.colores'       => 'string|sometimes|nullable',
            'ad.texto'         => 'string|sometimes|nullable',
            'ad.fecha_inicio'  => 'date|sometimes|nullable',
            'ad.fecha_fin'     => 'date|sometimes|nullable',

            'safety' => [Rule::requiredIf($this->input('license_type_id') == 14), 'array', 'nullable'],
            'safety.destino'  => 'integer',

            'compatibility_certificate' => [Rule::requiredIf($this->input('license_type_id') == 16), 'array', 'nullable'],
            'compatibility_certificate.land_use_id'            => 'integer|sometimes',
            'compatibility_certificate.land_use_description_id'=> 'integer|sometimes',
            'compatibility_certificate.medidas_colindancia'    => 'string|sometimes',
            'compatibility_certificate.uso_actual'             => 'string|sometimes',
            'compatibility_certificate.uso_propuesto'          => 'string|sometimes',

            's_f_d' => [Rule::requiredIf($this->input('license_type_id') == 22), 'array', 'nullable'],
            's_f_d.descripcion'               => 'string|sometimes|nullable',
            's_f_d.medidas_colindancia'       => 'string|sometimes|nullable',
            // 'compatibilidad.m2_ocupacion'   => 'numeric|sometimes|nullable',

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
        //? numbers in db, id license type
        return $this->input('license_type_id') >= 1 && $this->input('license_type_id') <= 6 ||
        ($this->input('license_type_id') >= 8 && $this->input('license_type_id') <= 11) ||
        ($this->input('license_type_id') == 15) ||
        ($this->input('license_type_id') >= 25 && $this->input('license_type_id') <= 28);
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
