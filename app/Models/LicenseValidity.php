<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class LicenseValidity extends Model
{
    use HasFactory, LogsActivity;

    public $timestamps = false;

    protected $fillable = [
        'fecha_autorizacion',
        'fecha_fin_vigencia',
        'dias_total',
        'license_id',
    ];

    protected $casts = [
        'fecha_autorizacion' => 'date',
        'fecha_fin_vigencia' => 'date',
        'dias_total' => 'integer',
    ];

    protected $with = [];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logOnly(['*'])
        ->setDescriptionForEvent(fn(string $eventName) => "{$this->id}'s data has been {$eventName}")
        ->useLogName('Licencias (Vigencia)')
        ->logOnlyDirty() //?Logging only the changed attributes
        ->dontSubmitEmptyLogs();
    }

    public function license()
    {
        return $this->belongsTo(License::class);
    }
}
