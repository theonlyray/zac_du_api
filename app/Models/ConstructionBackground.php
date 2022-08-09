<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class ConstructionBackground extends Model
{
    use HasFactory, LogsActivity;

    public $timestamps = false;

    protected $fillable = [
        'prior_license_id', 'physical_prior_license_id',
        'fecha', 'current_license_id',
    ];


    protected $casts = [
        'fecha' => 'datetime',
    ];

    protected $with = [
        'priorLicense'
    ];
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logOnly(['*'])
        ->setDescriptionForEvent(fn(string $eventName) => "{$this->folio}'s data has been {$eventName}")
        ->useLogName('Licencias (Antecedentes)')
        ->logOnlyDirty() //?Logging only the changed attributes
        ->dontSubmitEmptyLogs();
    }

    public function license()
    {
        return $this->belongsTo(License::class, 'current_license_id', 'id');
    }

    public function priorLicense()
    {
        return $this->belongsTo(License::class, 'prior_license_id', 'id');
    }
}
