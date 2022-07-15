<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class LicenseRequirement extends Model
{
    use HasFactory, LogsActivity;

    const CREATED_AT = 'fecha_registro';
    const UPDATED_AT = 'fecha_actualizacion';

    protected $fillable = [
        'archivo_nombre', 'archivo_ubicacion', 'archivo_url',
        'comentario', 'estatus','fecha_registro',
        'fecha_actualizacion', 'fecha_autorizacion',
        'requirement_id', 'license_id'
    ];

    protected $hidden = [];

    protected $casts = [
        'fecha_registro' => 'datetime',
        'fecha_actualizacion' => 'datetime',
        'fecha_autorizacion' => 'datetime',
    ];

    protected $with = [ 'requirement' ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logOnly(['*'])
        ->setDescriptionForEvent(fn(string $eventName) => "{$this->archivo_nombre}'s data has been {$eventName}")
        ->useLogName('Requisitos de Licencia')
        ->logOnlyDirty() //?Logging only the changed attributes
        ->dontSubmitEmptyLogs();
    }


    public function getEstatusAttribute($attribute)
    {
        switch ($attribute) {
            case 0: return 'Sin carga';
            case 1: return 'Doc. cargado';
            case 2: return 'Doc. con observaciones';
            case 3: return 'Doc. corregido';
            case 4: return 'Doc. Validado';
            default: return 'Undefined';
        }
    }
    /**
     * Get the license that owns the files.
     */
    public function license()
    {
        return $this->belongsTo(License::class);
    }

    /**
     * Get the license that owns the files.
     */
    public function requirement()
    {
        return $this->belongsTo(Requirement::class);
    }
}
