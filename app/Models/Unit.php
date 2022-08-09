<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Unit extends Model
{
    use HasFactory, LogsActivity;

    const CREATED_AT = 'fecha_registro';
    const UPDATED_AT = 'fecha_actualizacion';

    protected $fillable = [
        'nombre', 'department_id',
        'fecha_registro', 'fecha_actualizacion',
    ];

    protected $with = [];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logOnly(['*'])
        ->setDescriptionForEvent(fn(string $eventName) => "{$this->nombre}'s data has been {$eventName}")
        ->useLogName('Unidades')
        ->logOnlyDirty() //?Logging only the changed attributes
        ->dontSubmitEmptyLogs();
    }

    /**
     * Retrieve department
     */
    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    /**
     * Retrieve users
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }

    public static function getUnitsByRole(User $user)
    {
        if ($user->hasRole(['jefeSDUMA'])) {
            return Unit::all();
        }else{
            return Unit::where('department_id', $user->department[0]->id)->get();
        }
    }
}
