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
        $licenseType = $this->input('license_type_id');

        $minConstValue = self::setMinConstValue();
        $maxConstValue = self::setMaxConstValue();

        $isConstruction = $this->checkLicenseType->isConstruction(
            $this->input('license_type_id')
        );

        $isAd = $this->checkLicenseType->isAd(
            $this->input('license_type_id')
        );

        $propertyObject = [
            'property'          => 'required|array',
            'property.calle'      => 'sometimes|string',
            'property.no'         => 'sometimes|string',
            'property.colonia'    => 'sometimes|string',
            'property.seccion'    => 'sometimes|string',
            'property.manzana'    => 'sometimes|string',
            'property.lote'       => 'sometimes|string',
            'property.no_predial' => 'sometimes|string',
            'property.comunidad'  => 'sometimes|string',
            'property.cuartel'    => 'sometimes|string',
            'property.zona'       => 'sometimes|string|nullable',
            'property.clave_catastral'   => 'sometimes|string',
            'property.sup_terreno'       => 'sometimes|numeric',
            'property.sup_construida'    => 'sometimes|numeric',
            'property.sup_no_construida' => 'sometimes|numeric',
            'property.latitud'           => 'sometimes|string',
            'property.longitud'          => 'sometimes|string',
            'property.mapa'              => 'sometimes|string',
            'property.cuartel'           => 'sometimes|string',
        ];

        $stgSmtNll = 'sometimes|string|nullable';
        $ownerObject = [
            'owner'                   => 'array',
            'owner.nombre_apellidos'  => $stgSmtNll,
            'owner.rfc'               => $stgSmtNll,
            'owner.domicilio'         => $stgSmtNll,
            'owner.ocupacion'         => $stgSmtNll,
            'owner.telefono'          => $stgSmtNll,
        ];

        $constructionObject = [
            'construction'                           => 'nullable|array',
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
        ];

        $backgroundsObject = [
            // 'backgrounds'                      => [Rule::requiredIf($isConstruction)],
            'backgrounds.data.*.prior_license_id'           =>
                [Rule::requiredIf(is_null($this->input('backgrounds.data.*.physical_prior_license_id'))),'nullable','integer','exists:licenses,id'],//? digital background
            'backgrounds.data.*.physical_prior_license_id'  =>
                [Rule::requiredIf(is_null($this->input('backgrounds.data.*.prior_license_id'))),'nullable','string'],//? physical background
            'backgrounds.data.*.fecha'  =>
                [Rule::requiredIf(is_null($this->input('backgrounds.data.*.prior_license_id'))),'nullable','date'],//?required if is physical background
        ];

        $adsObject = [
            'ads.*.tipo'          => 'string',
            'ads.*.cantidad'      => 'integer|sometimes|nullable',
            'ads.*.largo'         => 'numeric|sometimes|min:0|nullable',
            'ads.*.ancho'         => 'numeric|sometimes|min:0|nullable',
            'ads.*.alto'          => 'numeric|sometimes|min:0|nullable',
            'ads.*.colores'       => 'string|sometimes|nullable',
            'ads.*.texto'         => 'string|sometimes|nullable',
            'ad.meses'          => 'integer|sometimes|nullable|max:11',
        ];

        $safetyObject = [
            'safety' => 'array',
            'safety.destino'  => 'integer',
        ];

        $usesObject = [
            'uses' => 'array',
            'uses.medidas_colindancia'    => 'string|sometimes',
            'uses.uso_actual'             => 'string|sometimes',
            'uses.uso_propuesto'          => 'string|sometimes',
        ];

        $sfdObject = [
            's_f_d' => 'array',
            's_f_d.actividades'                 => 'array',
            's_f_d.actividades.*.actividad'             => 'string|required',
            's_f_d.actividades.*.medidas_colindancia'   => 'string|required',
            's_f_d.actividades.*.descripcion'           => 'string|required',
            's_f_d.actividades.*.observaciones'         => 'string|required',
            's_f_d.actividades.*.lotes'               => 'array|nullable|sometimes',
            's_f_d.actividades.*.lotes.*.clave'       => 'nullable|sometimes|string',
            's_f_d.actividades.*.lotes.*.colonia'     => 'nullable|sometimes|string',
            's_f_d.actividades.*.lotes.*.lote'        => 'nullable|sometimes|string',
            's_f_d.actividades.*.lotes.*.manzana'     => 'nullable|sometimes|numeric',
            's_f_d.actividades.*.lotes.*.superficie'  => 'nullable|sometimes|numeric',
            's_f_d.actividades.*.lotes.*.propietario' => 'nullable|sometimes|string',
        ];

        $validityObject = [
            'validity'                      => 'sometimes|nullable',
            'validity.fecha_autorizacion'   => 'sometimes|date|nullable',
            'validity.fecha_fin_vigencia'   => 'sometimes|date|nullable',
            'validity.dias_total'           => 'sometimes|int|nullable',
        ];

        $selfBuildObject = [
            'self_build'                => 'sometimes|nullable',
            'self_build.tipo_obra'      => 'required|string',
            'self_build.construction'   => 'required|string',
            'self_build.nivel'          => 'required|string',
            'self_build.coadyuvante'    => 'required|string',
            'self_build.sup_total'      => 'required|numeric',
            'self_build.calle'          => 'required|string',
            'self_build.colonia'        => 'required|string',
            'self_build.propietario'    => 'required|string',
        ];

        $rules = [
            'license_type_id'   => 'required|integer|exists:license_types,id',
        ];
        $rules = array_merge($rules, $validityObject);

        if ($licenseType != 20 && $licenseType != 13){
            $rules = array_merge($rules, $propertyObject);
        }
        if ($isConstruction) {
            $rules = array_merge($rules, $backgroundsObject, $constructionObject, $ownerObject);
        }
        if ($isAd) {
            $rules = array_merge($rules, $adsObject, $ownerObject);
        }
        if($licenseType == 13){
            $rules = array_merge($rules, $selfBuildObject);
        }
        if($licenseType == 14){
            $rules = array_merge($rules, $safetyObject);
        }
        if($licenseType == 16){
            $rules = array_merge($rules, $usesObject);
        }
        if($licenseType == 22){
            $rules = array_merge($rules, $sfdObject);
        }
        return $rules;

    }

    public function setMinConstValue()
    {
        switch ($this->input('license_type_id')) {
            case 1: return '1'; break;
            case 2: return '45'; break;
            case 3: return '1000'; break;
            case 5: return '1'; break;
            case 27: return '45'; break;
            default: return '0'; break;
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
