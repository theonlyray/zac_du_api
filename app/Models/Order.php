<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Order extends Model
{
    use HasFactory, LogsActivity;

    const CREATED_AT = 'fecha_registro';
    const UPDATED_AT = 'fecha_actualizacion';

    protected $fillable = [
            'total','no_ref_pago','validada','pagada',
            'fecha_registro','fecha_actualizacion',
            'fecha_autorizacion', 'hash', 'validator_id',
            'creator_id','license_id',
    ];

    protected $hidden = [];

    protected $casts = [
        'fecha_registro' => 'datetime',
        'fecha_actualizacion' => 'datetime',
        'fecha_autorizacion' => 'datetime',
        'pagada' => 'boolean',
        'validada' => 'boolean',
        'total' => 'decimal:2',
        // 'duties.cantidad' => 'double',
    ];

    protected $with = [];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logOnly(['*'])
        ->setDescriptionForEvent(fn(string $eventName) => "{$this->id}'s data has been {$eventName}")
        ->useLogName('Ordenes')
        ->logOnlyDirty() //?Logging only the changed attributes
        ->dontSubmitEmptyLogs();
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id', 'id');
    }

    public function license()
    {
        return $this->belongsTo(License::class);
    }

    // public function duties()
    // {
    //     return $this->belongsToMany(Duty::class, 'order_duties', 'order_id', 'duty_id')
    //         ->withPivot('cantidad', 'total');
    // }
    public function duties()
    {
        return $this->hasMany(OrderDuty::class);
    }

    /**
     * Get the order's file.
     */
    public function file()
    {
        return $this->morphOne(File::class, 'fileable');
    }
}
