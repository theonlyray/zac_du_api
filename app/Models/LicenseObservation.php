<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class LicenseObservation extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'observaciones', 'solventada',
        'path', 'url',
        'user_id', 'license_id',
    ];

    protected $casts = [
        'solventada' => 'boolean'
        // 'fecha_autorizacion' => 'date',
        // 'fecha_fin_vigencia' => 'date',
    ];

    protected $with = [ 'user' ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logOnly(['*'])
        ->setDescriptionForEvent(fn(string $eventName) => "{$this->observaciones}'s data has been {$eventName}")
        ->useLogName('Observaciones')
        ->logOnlyDirty() //?Logging only the changed attributes
        ->dontSubmitEmptyLogs();
    }

    public function license()
    {
        return $this->belongsTo(License::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
