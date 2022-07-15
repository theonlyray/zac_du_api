<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class ConstructionDescription extends Model
{
    use HasFactory, LogsActivity;

    public $timestamps = false;

    protected $fillable = [
        'sotano', 'planta_baja', 'mezzanine', 'primer_piso',
        'segundo_piso', 'tercer_piso', 'cuarto_piso', 'quinto_piso',
        'sexto_piso', 'descubierta', 'sup_total_amp_reg_const', 'descripcion',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logOnly(['*'])
        ->setDescriptionForEvent(fn(string $eventName) => "{$this->folio}'s data has been {$eventName}")
        ->useLogName('Licencias (Descripcion de Construccion)')
        ->logOnlyDirty() //?Logging only the changed attributes
        ->dontSubmitEmptyLogs();
    }

    public function license()
    {
        return $this->belongsTo(License::class);
    }
}
