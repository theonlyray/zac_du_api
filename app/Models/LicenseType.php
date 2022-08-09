<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class LicenseType extends Model
{
    use HasFactory, LogsActivity;

    const CREATED_AT = 'fecha_registro';
    const UPDATED_AT = 'fecha_actualizacion';

    protected $fillable = [
        'id', 'nombre', 'nota','descripcion', 'activo', 'particular',
        'fecha_registro', 'fecha_actualizacion', 'department_id',
    ];

    protected $casts = [
        'activo' => 'boolean',
        'particular' => 'boolean',
    ];

    protected $with = [

    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['*'])
            ->setDescriptionForEvent(fn(string $eventName) => "{$this->nombre}'s data has been {$eventName}")
            ->useLogName('Tipos de Licencias')
            ->logOnlyDirty() //?Logging only the changed attributes
            ->dontSubmitEmptyLogs();
    }

    /**
     * Get the department that owns the licenseTypes.
     */
    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    /**
     * Get the requirements for the license type.
     */
    public function requirements()
    {
        return $this->hasMany(Requirement::class);
    }

    /**
     * Get the licenses for the license type.
     */
    public function licenses()
    {
        return $this->hasMany(License::class);
    }

    /**
     * returns the list of license types according to the user role in the request
     * @param User user
     * @return array
     */
    public static function getLicenseTypesByRoleUser(User $user){
        $licenseTypes = [];
        //?set in an array departmentIds
        if($user->hasRole(['jefeSDUMA'])){//?
            $licenseTypes = self::all();
        }
        else if(!$user->hasRole(['dro', 'particular'])){//?superadmin, mpio
            $userDepartmentIds = $user->department->pluck('id')->toArray();
            $licenseTypes = self::whereIn('department_id', $userDepartmentIds)->get();
        }else{//? applicants
            $user->hasRole(['dro']) ?
                $licenseTypes = self::where('activo', true)->get() : //?dro
                $licenseTypes = self::where('activo', true)->where('particular', true)->get(); //?particular
        }
        return $licenseTypes;
    }
}
