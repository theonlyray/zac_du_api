<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Duty extends Model
{
    use HasFactory, LogsActivity;

    const CREATED_AT = 'fecha_registro';
    const UPDATED_AT = 'fecha_actualizacion';

    protected $fillable = [
        'descripcion', 'clave', 'unidad', 'precio', 'activo', 'department_id'
    ];

    protected $hidden = [];

    protected $with = [];

    protected $casts = [
        'precio' => 'float',
        'activo' => 'boolean',
    ];

    public function getActivitylogOptions(): LogOptions{
        return LogOptions::defaults()
            ->logOnly(['*'])
            ->setDescriptionForEvent(fn(string $eventName) => "{$this->descripcion}'s data has been {$eventName}")
            ->useLogName('Derechos')
            ->logOnlyDirty() //?Logging only the changed attributes
            ->dontSubmitEmptyLogs();
    }

    /**
     * Multiply the duty's price by the variable uma in app.php
     *
     * @param  string  $value
     * @return string
     */
    public function getPrecioAttribute($value)
    {
        return $value * config('app.uma');
    }

     /**
     * Get the department that owns the duty.
     */
    public function department()
    {
        return $this->belongsTo(Department::class);
    }

     /**
     * Get the orders that owns the duty.
     */
    public function orders(){
        return $this->belongsToMany(Order::class, 'order_duties', 'duty_id', 'order_id');
    }

    /**
     * returns the list of duties according to the user role in the request and department id
     * @param int departmentId
     * @param User user
     * @return array
     */
    public static function getDutiesByDepartmentIdAndUserRole(int $departmentId, User $user){
        $duties = [];
        if(!$user->hasRole(['dro', 'particular'])){//?superadmin, mpio
            $duties = self::where('department_id', $departmentId)->get();
        }else{//? dro, particular
            $duties = self::where('department_id', $departmentId)->where('activo', true)->get();
        }
        return $duties;
    }
}
