<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class LicenseValidation extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'descripcion',
        'user_id',
        'license_id',
        'created_at'
    ];

    protected $casts = [
        // 'fecha_autorizacion' => 'date',
        // 'fecha_fin_vigencia' => 'date',
        // 'dias_total' => 'integer',
    ];

    protected $with = [ 'user' ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logOnly(['*'])
        ->setDescriptionForEvent(fn(string $eventName) => "{$this->descripcion}'s data has been {$eventName}")
        ->useLogName('Validaciones')
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
