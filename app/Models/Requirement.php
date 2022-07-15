<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Requirement extends Model
{
    use HasFactory, LogsActivity;

    const CREATED_AT = 'fecha_registro';
    const UPDATED_AT = 'fecha_actualizacion';

    protected $fillable = [
        'id', 'nombre', 'nota','descripcion', 'activo',
        'obligatorio', 'es_plano', 'fecha_registro',
        'fecha_actualizacion', 'license_type_id'
    ];

    protected $casts = [
        'activo'        => 'boolean',
        'obligatorio'   => 'boolean',
        'es_plano'      => 'boolean',
    ];

    protected $hidden = [];

    protected $with = [];

    public function getActivitylogOptions(): LogOptions{
        return LogOptions::defaults()
            ->logOnly(['*'])
            ->setDescriptionForEvent(fn(string $eventName) => "{$this->nombre}'s data has been {$eventName}")
            ->useLogName('Requisitos')
            ->logOnlyDirty() //?Logging only the changed attributes
            ->dontSubmitEmptyLogs();
    }
    /**
     * Get the license type that owns the requirements.
     */
    public function licenseType()
    {
        return $this->belongsTo(LicenseType::class);
    }

    /**
     * returns the list of requirements according to the user role in the request and license type id
     * @param int licenseTypeId
     * @param User user
     * @return array
     */
    public static function getRequirementsByLicenseTypeAndUserRole(int $licenseTypeId, User $user){
        $requirements = [];
        if(!$user->hasRole(['dro', 'particular'])){//?superadmin, mpio
            $requirements = self::where('license_type_id', $licenseTypeId)->get();
        }else{//? dro, particular
            $requirements = self::where('license_type_id', $licenseTypeId)->where('activo', true)->get();
        }
        return $requirements;
    }
}
