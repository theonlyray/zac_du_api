<?php

namespace App\Http\Requests\Licenses;

use App\Services\CheckLicenseType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class StoreLicenseRequest extends FormRequest
{
    protected $checkLicenseType;

    public function __construct()
    {
        $this->checkLicenseType = new CheckLicenseType();
    }
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
        $minConstValue = self::setMinConstValue();
        $maxConstValue = self::setMaxConstValue();

        $isConstruction = $this->checkLicenseType->isConstruction(
            $this->input('license_type_id')
        );

        $isAd = $this->checkLicenseType->isAd(
            $this->input('license_type_id')
        );


        return [
            'license_type_id'   => 'required|integer|exists:license_types,id',
            // 'property_id'       => 'required|integer|exists:properties,id',

            'property'            => [Rule::requiredIf($this->input('license_type_id') != 20 && $this->input('license_type_id') != 13), 'array'],
            'property.calle'      => 'sometimes|string',
            'property.no'         => 'sometimes|string',
            'property.colonia'    => 'sometimes|string',
            'property.seccion'    => 'sometimes|string',
            'property.manzana'    => 'sometimes|string',
            'property.lote'       => 'sometimes|string',
            'property.no_predial' => 'sometimes|string',
            'property.clave_catastral'   => 'sometimes|string',
            'property.sup_terreno'       => 'sometimes|numeric',
            'property.sup_construida'    => 'sometimes|numeric',
            'property.sup_no_construida' => 'sometimes|numeric',
            'property.latitud'           => 'sometimes|string',
            'property.longitud'          => 'sometimes|string',
            'property.mapa'              => 'sometimes|string',

            'backgrounds'                      => [Rule::requiredIf($isConstruction)],
            'backgrounds.data.*.prior_license_id'           =>
                [Rule::requiredIf(is_null($this->input('backgrounds.data.*.physical_prior_license_id'))),'nullable','integer','exists:licenses,id'],//? digital background
            'backgrounds.data.*.physical_prior_license_id'  =>
                [Rule::requiredIf(is_null($this->input('backgrounds.data.*.prior_license_id'))),'nullable','string'],//? physical background
            'backgrounds.data.*.fecha'  =>
                [Rule::requiredIf(is_null($this->input('backgrounds.data.*.prior_license_id'))),'nullable','date'],//?required if is physical background

            'construction'                      => [Rule::requiredIf($isConstruction),'nullable','array'],
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
            'construction.sup_total_amp_reg_const'   => ['sometimes','numeric',"min:{$minConstValue}", "max:{$maxConstValue}"],
            'construction.descripcion'               => 'sometimes|string',

            //?owner data is required for dros, if user is particular, the owner's data will be those of the user himself
            'owner'                   => [Rule::requiredIf($isConstruction), 'array'],
            // 'required_if:propietario.ownerFlag,flase|array',
            'owner.nombre_apellidos'  => 'sometimes|string',
            'owner.rfc'               => 'sometimes|string',
            'owner.domicilio'         => 'sometimes|string',
            'owner.ocupacion'         => 'sometimes|string',
            'owner.telefono'          => 'sometimes|string',

            'ad' => [Rule::requiredIf($isAd), 'array', 'nullable'],
            'ad.colocacion'    => [Rule::requiredIf($isAd), 'string'],
            'ad.tipo'          => [Rule::requiredIf($isAd), 'string'],
            'ad.cantidad'      => 'integer|sometimes|nullable',
            'ad.largo'         => 'numeric|sometimes|min:0|nullable',
            'ad.ancho'         => 'numeric|sometimes|min:0|nullable',
            'ad.alto'          => 'numeric|sometimes|min:0|nullable',
            'ad.colores'       => 'string|sometimes|nullable',
            'ad.texto'         => 'string|sometimes|nullable',
            'ad.fecha_inicio'  => 'date|sometimes|nullable',
            'ad.fecha_fin'     => 'date|sometimes|nullable',

            // 'boundaries' => [Rule::requiredIf($this->input('license_type_id') == 16), 'array'],
            // 'boundaries.descripcion'    => 'string|required|nullable',
            // 'compatibilidad.ubicacion'  => 'string|required|nullable',

            'safety' => [Rule::requiredIf($this->input('license_type_id') == 14), 'array'],
            'safety.destino'  => 'integer',

            'uses' => [Rule::requiredIf($this->input('license_type_id') == 16), 'array'],
            'uses.medidas_colindancia'    => 'string|sometimes',
            'uses.uso_actual'             => 'string|sometimes',
            'uses.uso_propuesto'          => 'string|sometimes',

            's_f_d' => [Rule::requiredIf($this->input('license_type_id') == 22), 'array'],
            's_f_d.descripcion'               => 'string|sometimes|nullable',
            's_f_d.medidas_colindancia'       => 'string|sometimes|nullable',
            // 'compatibilidad.m2_ocupacion'   => 'numeric|sometimes|nullable',

            'validity'                      => 'sometimes|nullable',
            'validity.fecha_autorizacion'   => 'sometimes|date|nullable',
            'validity.fecha_fin_vigencia'   => 'sometimes|date|nullable',
            'validity.dias_total'           => 'sometimes|int|nullable',
        ];
    }

    public function setMinConstValue()
    {
        switch ($this->input('license_type_id')) {
            case 1: return '1'; break;
            case 2: return '45'; break;
            case 3: return '1000'; break;
            case 5: return '50'; break;
            case 27: return '45'; break;
            default: return '1'; break;
        }
    }

    public function setMaxConstValue()
    {
        switch ($this->input('license_type_id')) {
            case 1: return '49.99'; break;
            case 2: return '999.99'; break;
            case 26: return '49.99'; break;
            default: return '100000'; break;
        }
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
        $maxConstValue = self::setMaxConstValue();
        return [
            'exists'        => 'El campo :attribute no existe.',
            'required'      => 'El campo :attribute es requerido',
            'string'        => 'El campo :attribute debe ser un texto válido.',
            'integer'       => 'El campo :attribute debe ser un número entero.',
            'date'          => 'El campo :attribute debe ser una fecha válida.',
            'numeric'       => 'El campo :attribute debe ser un número válido.',
            'min'           => 'El campo :attribute debe tener un valor mínimo de :min.',
            'required_if'   => 'El campo :attribute es requerido cuando :other es :value',
            'max'           => "La superficie total de construcción no debe ser mayor a {$maxConstValue} m2",
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
