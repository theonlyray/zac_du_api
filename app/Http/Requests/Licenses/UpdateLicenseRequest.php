<?php

namespace App\Http\Requests\Licenses;

use App\Services\CheckLicenseType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class UpdateLicenseRequest extends FormRequest
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

        $stgReq = 'required|string';

        $propertyObject = [
            'property'          => 'required|array',
            'property.calle'      => 'sometimes|string|nullable',
            'property.no'         => 'sometimes|string|nullable',
            'property.colonia'    => 'sometimes|string|nullable',
            'property.seccion'    => 'sometimes|string|nullable',
            'property.manzana'    => 'sometimes|string|nullable',
            'property.lote'       => 'sometimes|string|nullable',
            'property.no_predial' => 'sometimes|string|nullable',
            'property.comunidad'  => 'sometimes|string|nullable',
            'property.cuartel'    => 'sometimes|string|nullable',
            'property.zona'       => 'sometimes|string|nullable',
            'property.clave_catastral'   => 'sometimes|string|nullable',
            'property.sup_terreno'       => 'sometimes|numeric|nullable',
            'property.sup_construida'    => 'sometimes|numeric|nullable',
            'property.sup_no_construida' => 'sometimes|numeric|nullable',
            'property.latitud'           => 'sometimes|string|nullable',
            'property.longitud'          => 'sometimes|string|nullable',
            'property.mapa'              => 'sometimes|string|nullable',
        ];

        $ownerObject = [
            'owner'                   => 'array',
            'owner.nombre_apellidos'  => 'sometimes|string|nullable',
            'owner.rfc'               => 'sometimes|string|nullable',
            'owner.domicilio'         => 'sometimes|string|nullable',
            'owner.ocupacion'         => 'sometimes|string|nullable',
            'owner.telefono'          => 'sometimes|string|nullable',
        ];

        $constructionObject = [
            'construction'                           => 'nullable|array',
            'construction.sotano'                    => 'sometimes|numeric|min:0|nullable',
            'construction.planta_baja'               => 'sometimes|numeric|min:0|nullable',
            'construction.mezzanine'                 => 'sometimes|numeric|min:0|nullable',
            'construction.primer_piso'               => 'sometimes|numeric|min:0|nullable',
            'construction.segundo_piso'              => 'sometimes|numeric|min:0|nullable',
            'construction.tercer_piso'               => 'sometimes|numeric|min:0|nullable',
            'construction.cuarto_piso'               => 'sometimes|numeric|min:0|nullable',
            'construction.quinto_piso'               => 'sometimes|numeric|min:0|nullable',
            'construction.sexto_piso'                => 'sometimes|numeric|min:0|nullable',
            'construction.descubierta'               => 'sometimes|numeric|min:0|nullable',
            'construction.sup_total_amp_reg_const'   => ['sometimes','numeric',"min:{$minConstValue}", "max:{$maxConstValue}", 'nullable'],
            'construction.descripcion'               => 'sometimes|string|nullable',
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
            // 'ads'               =>'array|nullable',
            // 'ads.*.colocacion'    => [Rule::requiredIf($isAd), 'string'],
            'ads.*.tipo'          => 'string',
            'ads.*.cantidad'      => 'integer|sometimes|nullable',
            'ads.*.largo'         => 'numeric|sometimes|min:0|nullable',
            'ads.*.ancho'         => 'numeric|sometimes|min:0|nullable',
            'ads.*.alto'          => 'numeric|sometimes|min:0|nullable',
            'ads.*.colores'       => 'string|sometimes|nullable',
            'ads.*.texto'         => 'string|sometimes|nullable',
            // 'ads.*.fecha_inicio'  => 'date|sometimes|nullable',
            // 'ads.*.fecha_fin'     => 'date|sometimes|nullable',
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
            's_f_d'                 => 'array',
            's_f_d.*.actividad'             => $stgReq,
            's_f_d.*.medidas_colindancia'   => $stgReq,
            's_f_d.*.descripcion'           => $stgReq,
            's_f_d.*.observaciones'         => $stgReq,
            's_f_d.*.sustento'              => $stgReq,
            's_f_d.*.lots'               => 'array|nullable',
            's_f_d.*.lots.*.clave'       => 'string',
            's_f_d.*.lots.*.colonia'     => 'string',
            's_f_d.*.lots.*.lote'        => 'string',
            's_f_d.*.lots.*.manzana'     => 'string',
            's_f_d.*.lots.*.superficie'  => 'numeric',
            's_f_d.*.lots.*.propietario' => 'string',
        ];

        $validityObject = [
            'validity'                      => 'sometimes|nullable',
            'validity.fecha_autorizacion'   => 'sometimes|date|nullable',
            'validity.fecha_fin_vigencia'   => 'sometimes|date|nullable',
            'validity.dias_total'           => 'sometimes|int|nullable',
        ];

        $selfBuildObject = [
            'self_build'                => 'sometimes|nullable',
            'self_build.tipo_obra'      => $stgReq,
            'self_build.construction'   => $stgReq,
            'self_build.nivel'          => $stgReq,
            'self_build.coadyuvante'    => $stgReq,
            'self_build.sup_total'      => 'required|numeric',
            'self_build.calle'          => $stgReq,
            'self_build.colonia'        => $stgReq,
            'self_build.propietario'    => $stgReq,
        ];

        $rules = [
            'license_type_id'   => 'required|integer|exists:license_types,id',
            'liberada'      => 'sometimes|boolean',
            'referencia'    => 'sometimes|string|nullable',
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
