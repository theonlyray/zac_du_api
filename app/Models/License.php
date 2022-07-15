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
            case 5: return 'Validado Primer Revision';
            case 6: return 'Observaciones Primer Revision';
            case 7: return 'Validado Segunda Revision';
            case 8: return 'Observaciones Segunda Revision';
            case 9: return 'Validado Tercera Revision';
            case 10: return 'Observaciones Tercera Revision';
            case 11: return 'Ficha de Pago Generada';
            case 12: return 'Pagado';
            case 13: return 'Proceso de Firmas';
            case 14: return 'Autorizado';
            case 15: return 'Cancelado';
            case 16: return 'Rechazado';
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
    public static function counter($user)
    {
        $result['Total'] = 0;

        if ($user->hasRole(['directorDpt', 'subDirectorDpt', 'jefeUnidadDpt', 'colaboradorDpt'])) {
            $gralWhereSentence = fn($status) =>
                [
                    ['estatus', $status],
                    // ['licenseType.department_id', $user->department[0]->id],
                ];

            $result['Proceso'] =
            License::where([
                ['estatus', '>=', 1],
                ['estatus', '<=', 13],
                // ['licenseType.department_id', $user->department[0]->id],
            ])
            ->whereHas('licenseType', function ($q) use($user){
                $q->where('department_id',$user->department[0]->id);
            })->count();

            $result['Autorizadas'] =
            License::where($gralWhereSentence(14))
            ->whereHas('licenseType', function ($q) use($user){
                $q->where('department_id',$user->department[0]->id);
            })->count();

            $result['Canceladas'] =
            License::where($gralWhereSentence(15))
            ->whereHas('licenseType', function ($q) use($user){
                $q->where('department_id',$user->department[0]->id);
            })->count();

            $result['Rechazadas'] =
            License::where($gralWhereSentence(16))
            ->whereHas('licenseType', function ($q) use($user){
                $q->where('department_id',$user->department[0]->id);
            })->count();
        }
        else if ($user->hasRole(['dro', 'particular'])) {
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
                        ['estatus', '<=', 13],
                    ])->count();

            $result['Autorizadas'] =
            License::where($gralWhereSentence(14))
                ->count();

            $result['Canceladas'] =
            License::where($gralWhereSentence(15))
                ->count();

            $result['Rechazadas'] =
            License::where($gralWhereSentence(16))
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
            case 'Autorizadas': $statusInt = 14; break;
            case 'Canceladas':  $statusInt = 15; break;
            case 'Rechazadas':  $statusInt = 16; break;

            default: $statusInt = 0; break;
        }

        if ($user->hasRole(['directorDpt', 'subDirectorDpt', 'jefeUnidadDpt', 'colaboradorDpt'])) {
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
            ];

            if ($status === 'Proceso') {
                return License::where(
                    [
                        ['estatus', '>=', 1],
                        ['estatus', '<=', 13],
                        // ['licenseType.department_id', $user->department[0]->id],
                    ]
                )->whereHas('licenseType', function ($q) use($user){
                    $q->where('department_id',$user->department[0]->id);
                })
                ->with($withArray)
                ->orderBy('licenses.id','desc')
                ->get();
            }
            return License::where($gralWhereSentence())
                ->whereHas('licenseType', function ($q) use($user){
                    $q->where('department_id',$user->department[0]->id);
                })
                ->with($withArray)
                ->orderBy('licenses.id','desc')
                ->get();
        }
        else if ($user->hasRole(['dro', 'particular'])) {
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
            ];

            if ($status === 'Proceso') {
                return License::where(
                    [
                        ['user_id', $user->id],
                        ['estatus', '>=', 1]
                    ]
                )->where('estatus', '<=', 13)
                ->with($withArray)
                ->orderBy('licenses.id','desc')
                ->get();
            }
            return License::where($gralWhereSentence())
                ->with($withArray)
                ->orderBy('licenses.id','desc')
                ->get();
        }
    }
}
