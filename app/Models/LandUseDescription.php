<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class LandUseDescription extends Model
{
    use HasFactory, LogsActivity;


    const CREATED_AT = 'fecha_registro';
    const UPDATED_AT = 'fecha_actualizacion';

    protected $fillable = [
        'descripcion', 'uma', 'land_use_id'
    ];

    protected $casts = [
        'uma' => 'double'
    ];


    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logOnly(['*'])
        ->setDescriptionForEvent(fn(string $eventName) => "{$this->descripcion}'s data has been {$eventName}")
        ->useLogName('Licencias')
        ->logOnlyDirty() //?Logging only the changed attributes
        ->dontSubmitEmptyLogs();
    }

    protected $appends = ['costo'];

    public function LandUse()
    {
        return $this->belongsTo(LandUse::class);
    }

    public function getCostoAttribute()
    {
        return $this->attributes['uma'] * config('app.uma');
    }
}
