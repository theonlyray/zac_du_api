<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompatibilityCertificate extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'medidas_colindancia', 'm2_ocupacion',
        'uso_actual', 'uso_propuesto',
        'usos_permitidos', 'usos_prohibidos',
        'usos_condicionales', 'observaciones',
        'resticciones', 'license_id',
    ];

    protected $casts = [
        'm2_ocupacion' => 'double',
    ];

    public function license()
    {
        return $this->belongsTo(License::class);
    }
}
