<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, LogsActivity;

    const CREATED_AT = 'fecha_registro';
    const UPDATED_AT = 'fecha_actualizacion';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id', 'nombre', 'correo', 'contrasenia',
        'validado', 'fecha_registro', 'fecha_actualizacion',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'contrasenia',
        // 'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'fecha_registro' => 'datetime',
        'fecha_actualizacion' => 'datetime',
        'validado' => 'boolean',
    ];

    protected $with = [];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logOnly(['*'])
        ->setDescriptionForEvent(fn(string $eventName) => "{$this->nombre}'s data has been {$eventName}")
        ->useLogName('Usuarios')
        ->logOnlyDirty() //?Logging only the changed attributes
        ->dontSubmitEmptyLogs();
    }

    /**
     * Get the applicant data associated with the user.
     */
    public function applicantData()
    {
        return $this->hasOne(ApplicantData::class);
    }

    /**
     * Get the specialties associated with the user.
     */
    public function specialties()
    {
        return $this->belongsToMany(Specialty::class, 'specialty_users', 'user_id', 'specialty_id')
            ->withPivot('id','no_registro','validado');
    }

    /**
     * Get the colleges that owns the user.
     */
    public function college()
    {
        return $this->belongsToMany(College::class, 'college_users', 'user_id', 'college_id')
            ->withPivot('validado');
    }

    /**
     * Get the departments that owns the user.
     */
    public function department()
    {
        return $this->belongsToMany(Department::class, 'department_users', 'user_id', 'department_id');
    }

    /**
     * Get the departments that owns the user.
     */
    public function unit()
    {
        return $this->belongsToMany(Unit::class, 'unit_users', 'user_id', 'unit_id');
    }

    /**
     * Get the user's image.
     */
    public function file()
    {
        return $this->morphOne(File::class, 'fileable');
    }

    /*
     *Get the user's properties.
     */
    public function properties()
    {
        return $this->hasMany(Property::class);
    }

    /**
     *Get de licenses associated with the user.
    */
    public function licenses()
    {
        return $this->hasMany(License::class);
    }

    /**
    *Get the observations associated with the user, rejections.
    */
    function observations()
    {
        return $this->hasMany(LicenseObservation::class);
    }

    /**
    *Get the validations associated with the user.
    */
    function validition()
    {
        return $this->hasMany(LicenseValidation::class);
    }

    /**
     * returns the list of users according to the user role in the request
     * @param string role to search
     * @return array
     */
    public function getUsersByRole($roleName)
    {
        $users = [];

        if (self::hasRole(['super-admin'])) {
            $users = self::whereHas('roles', function($q) use ($roleName) {
                $q->where('name',$roleName);
            })->get();

        }else{
            $withArray = ['college', 'department', 'specialties', 'applicantData', 'roles'];

            if (self::hasRole(['directorDpt','subDirectorDpt', 'jefeUnidadDpt','colaboradorDpt'])){
                 $relation = 'department';
                 $column = 'department_id';
                 $idsArray = auth()->user()->department->pluck('id')->toArray();
            }
            else if (self::hasRole(['directorCol','subDirectorCol','colaboradorCol'])){
                $relation = 'college';
                $column = 'college_id';
                $idsArray = auth()->user()->college->pluck('id')->toArray();
            }

            if (in_array($roleName, ['dro', 'particular'])){
                $users = self::whereHas('roles', function($q) use ($roleName) {
                    $q->where('name',$roleName);
                })->with($withArray)->get();
            }else{ //mpio and col
                $users = self::whereHas('roles', function($q) use ($roleName) {
                    $q->where('name',$roleName);
                    })->whereHas($relation, function($q) use ($column,$idsArray) {
                        $q->whereIn($column,$idsArray);
                    })->with($withArray)->get();
            }
        }
        return $users;
    }
}
