<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;


class License extends Model
{
    use HasFactory, LogsActivity;

    const CREATED_AT = 'fecha_registro';
    const UPDATED_AT = 'fecha_actualizacion';

    protected $fillable = [
            'folio','estatus','fecha_registro','fecha_actualizacion',
            'license_type_id','user_id','property_id',
    ];

    protected $hidden = [];

    protected $casts = [
        'fecha_registro' => 'datetime',
        'fecha_actualizacion' => 'datetime',
    ];

    protected $with = [];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logOnly(['*'])
        ->setDescriptionForEvent(fn(string $eventName) => "{$this->id}'s data has been {$eventName}")
        ->useLogName('Licencias')
        ->logOnlyDirty() //?Logging only the changed attributes
        ->dontSubmitEmptyLogs();
    }


    public function getEstatusAttribute($attribute)
    {
        switch ($attribute) {
            case 0: return 'Ingresado';
            case 1: return 'Docs. Cargados';
            case 2: return 'Docs. con Observaciones';
            case 3: return 'Docs. Corregidos';
            case 4: return 'Ingreso Validado';
            case 5: return 'Docs y Planos Validados';
            case 6: return 'Por Pagar';
            case 7: return 'Autorizado';
            case 8: return 'Cancelado';
            case 9: return 'Rechazado';
            default: return 'Undefined';
        }
    }


    /**
     * Get the license type for the license.
     */
    public function licenseType()
    {
        return $this->belongsTo(LicenseType::class);
    }

    /**
     * Get the user that owns the license.
     */
    public function applicant()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     *Get de license's property associated with the license.
    */
    // public function property()
    // {
    //     return $this->belongsTo(Property::class);
    // }
    public function property()
    {
        return $this->hasOne(Property::class);
    }


    /**
     *Get de license's backgrounds associated with the license.
    */
    public function backgrounds()
    {
        return $this->hasMany(ConstructionBackground::class, 'current_license_id', 'id');
    }

    /**
    *Get the construction description data associated with the license.
    */
    function construction()
    {
        return $this->hasOne(ConstructionDescription::class);
    }

    /**
    *Get the construction owner associated with the license.
    */
    function owner()
    {
        return $this->hasOne(ConstructionOwner::class);
    }

    /**
    *Get the validity associated with the license.
    */
    function validity()
    {
        return $this->hasOne(LicenseValidity::class);
    }

    /**
     * Get the ad description associated with the license.
     */
    public function ad()
    {
        return $this->hasOne(AdDescription::class);
    }

    /**
     * Get the Compatibility Certificate associated with the license.
     */
    public function compatibilityCertificate()
    {
        return $this->hasOne(CompatibilityCertificate::class);
    }

    /**
     * Get the SFD associated with the license.
     */
    public function SFD()
    {
        return $this->hasOne(SFD::class);
    }

    /**
     * Get the stracutural safety associated with the license.
     */
    public function safety()
    {
        return $this->hasOne(StructuralSafetyCertificate::class);
    }

    /**
     * Get the requirements associated with the license.
     */
    public function requirements()
    {
        return $this->hasMany(LicenseRequirement::class);
    }

    /**
     * Get the order associated with the license.
     */
    public function order()
    {
        return $this->hasOne(Order::class);
    }

    /**
    *Get the observations associated with the license, rejections.
    */
    function observations()
    {
        return $this->hasMany(LicenseObservation::class);
    }

    /**
    *Get the validations associated with the license.
    */
    function validations()
    {
        return $this->hasMany(LicenseValidation::class);
    }

    /**
     * return licenses number by status and user role
     * @param User $user
     * @return object count for each status
     */
    public static function counter(User $user)
    {
        $result['Total'] = 0;

        if ($user->hasRole(['jefeSDUMA'])) {
            $gralWhereSentence = fn($status) =>
                [
                    ['estatus', $status],
                    // ['licenseType.department_id', $user->department[0]->id],
                ];

            $result['Proceso'] =
            License::where([
                ['estatus', '>=', 1],
                ['estatus', '<=', 6],
                // ['licenseType.department_id', $user->department[0]->id],
            ])->count();

            $result['Autorizadas'] =
            License::where($gralWhereSentence(7))->count();

            $result['Canceladas'] =
            License::where($gralWhereSentence(8))->count();

            $result['Rechazadas'] =
            License::where($gralWhereSentence(9))->count();
        }else if ($user->hasRole(['directorDpt', 'subDirectorDpt', 'jefeUnidadDpt', 'colaboradorDpt'])) {
            $gralWhereSentence = fn($status) =>
                [
                    ['estatus', $status],
                    // ['licenseType.department_id', $user->department[0]->id],
                ];

            $result['Proceso'] =
            License::where([
                ['estatus', '>=', 1],
                ['estatus', '<=', 6],
                // ['licenseType.department_id', $user->department[0]->id],
            ])
            ->whereHas('licenseType', function ($q) use($user){
                $q->where('department_id',$user->department[0]->id);
            })->count();

            $result['Autorizadas'] =
            License::where($gralWhereSentence(7))
            ->whereHas('licenseType', function ($q) use($user){
                $q->where('department_id',$user->department[0]->id);
            })->count();

            $result['Canceladas'] =
            License::where($gralWhereSentence(8))
            ->whereHas('licenseType', function ($q) use($user){
                $q->where('department_id',$user->department[0]->id);
            })->count();

            $result['Rechazadas'] =
            License::where($gralWhereSentence(9))
            ->whereHas('licenseType', function ($q) use($user){
                $q->where('department_id',$user->department[0]->id);
            })->count();
        }else if ($user->hasRole(['dro', 'particular'])) {
            $gralWhereSentence = fn($status) =>
                [
                    ['user_id', $user->id],
                    ['estatus', $status]
                ];

            $result['Solicitudes'] =
            License::where($gralWhereSentence(0))
                ->count();

            $result['Proceso'] =
            License::where(
                    [
                        ['user_id', $user->id],
                        ['estatus', '>=', 1],
                        ['estatus', '<=', 6],
                    ])->count();

            $result['Autorizadas'] =
            License::where($gralWhereSentence(7))
                ->count();

            $result['Canceladas'] =
            License::where($gralWhereSentence(8))
                ->count();

            $result['Rechazadas'] =
            License::where($gralWhereSentence(9))
                ->count();

            // $result['Corresponsabilidades'] =
            //     License::whereHas('coresponsibles', function($q){
            //             $q->where('user_id', '=', $this->id);
            //         })
            //         ->where([
            //             ['license_type_id','=',$type],
            //             ['estatus','=', 1],
            //         ])->count();
            $result['Total'] += $result['Solicitudes'];
        }else if ($user->hasRole(['directorCol','subDirectorCol','colaboradorCol',]))
        {
            // logger($user->college[0]->id);
            /**
             *
             *
                return License::whereHas('applicant', function($q) use($collegeId){
                    $q->where('college_id', $collegeId);
                    })
                    ->where([
                        ['license_type_id',$typeLic],
                        ['estatus',1],
                    ])
                    ->count();
             *
             */
            $gralWhereSentence = fn($status) =>
                [
                    ['estatus', $status],
                    // ['licenseType.department_id', $user->department[0]->id],
                ];

            $result['Proceso'] =
            License::where([
                ['estatus', '>=', 1],
                ['estatus', '<=', 6],
                // ['licenseType.department_id', $user->department[0]->id],
            ])
            ->whereHas('applicant.college', function ($q) use($user){
                $q->where('college_users.college_id',$user->college[0]->id);
            })->count();

            $result['Autorizadas'] =
            License::where($gralWhereSentence(7))
            ->whereHas('applicant.college', function ($q) use($user){
                $q->where('college_users.college_id',$user->college[0]->id);
            })->count();

            $result['Canceladas'] =
            License::where($gralWhereSentence(8))
            ->whereHas('applicant.college', function ($q) use($user){
                $q->where('college_users.college_id',$user->college[0]->id);
            })->count();

            $result['Rechazadas'] =
            License::where($gralWhereSentence(9))
            ->whereHas('applicant.college', function ($q) use($user){
                $q->where('college_users.college_id',$user->college[0]->id);
            })->count();
        }

        $result['Total'] += $result['Proceso'] + $result['Autorizadas'] + $result['Canceladas'] + $result['Rechazadas'];
        return $result;
    }

    /**
     * return licenses list by status and user role
     * @param User $user
     * @param String status queried
     * @return object count for each status
     */
    public static function getLicencesList($user, $status)
    {
        switch ($status) {
            case 'Solicitudes': $statusInt = 0; break;
            case 'Autorizadas': $statusInt = 7; break;
            case 'Canceladas':  $statusInt = 8; break;
            case 'Rechazadas':  $statusInt = 9; break;

            default: $statusInt = 0; break;
        }

        if ($user->hasRole(['jefeSDUMA'])) {
            $gralWhereSentence = fn() =>
            [
                ['estatus', $statusInt],
                // ['licenseType.department_id', $user->department[0]->id],
            ];

            $withArray = [
                'applicant.applicantData',
                'licenseType',
                'property',
                'construction',
                'owner',
                'validity',
                'validations',
                'observations',
                'ad',
                'order'
            ];

            if ($status === 'Proceso') {
                $licenses = License::where(
                    [
                        ['estatus', '>=', 1],
                        ['estatus', '<=', 6],
                        // ['licenseType.department_id', $user->department[0]->id],
                    ]
                )->with($withArray)
                ->orderBy('licenses.id','desc')
                ->get();
                return self::sorter($licenses);
            }
            $licenses = License::where($gralWhereSentence())
                ->with($withArray)
                ->orderBy('licenses.id','desc')
                ->get();
            return self::sorter($licenses);
        }
        else if ($user->hasRole(['directorDpt', 'subDirectorDpt', 'jefeUnidadDpt', 'colaboradorDpt'])) {
            $gralWhereSentence = fn() =>
            [
                ['estatus', $statusInt],
                // ['licenseType.department_id', $user->department[0]->id],
            ];

            $withArray = [
                'applicant.applicantData',
                'licenseType',
                'property',
                'construction',
                'owner',
                'validity',
                'validations',
                'observations',
                'ad',
                'backgrounds',
                'order'
            ];

            if ($status === 'Proceso') {
                $licenses = License::where(
                    [
                        ['estatus', '>=', 1],
                        ['estatus', '<=', 6],
                        // ['licenseType.department_id', $user->department[0]->id],
                    ]
                )->whereHas('licenseType', function ($q) use($user){
                    $q->where('department_id',$user->department[0]->id);
                })
                ->with($withArray)
                ->orderBy('licenses.id','desc')
                ->get();
                return self::sorter($licenses);
            }
            $licenses = License::where($gralWhereSentence())
                ->whereHas('licenseType', function ($q) use($user){
                    $q->where('department_id',$user->department[0]->id);
                })
                ->with($withArray)
                ->orderBy('licenses.id','desc')
                ->get();

            return self::sorter($licenses);
        }
        else if ($user->hasRole(['directorCol','subDirectorCol','colaboradorCol',])) {
            $gralWhereSentence = fn() =>
            [
                ['estatus', $statusInt],
                // ['licenseType.department_id', $user->department[0]->id],
            ];

            $withArray = [
                'applicant.applicantData',
                'licenseType',
                'property',
                'construction',
                'owner',
                'validity',
                'validations',
                'observations',
                'ad',
                'backgrounds',
                'order'
            ];

            if ($status === 'Proceso') {
                $licenses = License::where(
                    [
                        ['estatus', '>=', 1],
                        ['estatus', '<=', 6],
                        // ['licenseType.department_id', $user->department[0]->id],
                    ]
                )->whereHas('applicant.college', function ($q) use($user){
                    $q->where('college_users.college_id',$user->college[0]->id);
                })
                ->with($withArray)
                ->orderBy('licenses.id','desc')
                ->get();
                return self::sorter($licenses);
            }
            $licenses = License::where($gralWhereSentence())
                ->whereHas('applicant.college', function ($q) use($user){
                    $q->where('college_users.college_id',$user->college[0]->id);
                })
                ->with($withArray)
                ->orderBy('licenses.id','desc')
                ->get();

            return self::sorter($licenses);
        }else if ($user->hasRole(['dro', 'particular'])) {
            $gralWhereSentence = fn() =>
            [
                ['user_id', $user->id],
                ['estatus', $statusInt]
            ];

            $withArray = [
                'licenseType',
                'property',
                'construction',
                'owner',
                'validity',
                'validations',
                'observations',
                'ad',
                'backgrounds',
                'order'
            ];

            if ($status === 'Proceso') {
                $licenses = License::where(
                    [
                        ['user_id', $user->id],
                        ['estatus', '>=', 1]
                    ]
                )->where('estatus', '<=', 6)
                ->with($withArray)
                ->get();

                return self::sorter($licenses);
            }
            $licenses = License::where($gralWhereSentence())
                ->with($withArray)
                ->orderBy('licenses.id','desc')
                ->get();

            //? $statusInt 0 request without folio
            return $statusInt == 0 ? $licenses : self::sorter($licenses);
        }
    }

    /**
    *  Sort licenses by folio,
    * explode folio and take the second value, int, to sort it
    *@param collect licenses to sort
    *@return collect licenses sorted by folio
    */
    static public function sorter($licenses)
    {
        $sorted = $licenses->sortBy(function ($license, $key) {
            $folioArray = explode('-',$license->folio);
            return $folioArray[1];
        });
        return collect($sorted->reverse()->values()->all());
    }
}
