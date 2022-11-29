<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdDescription extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'colocacion', 'tipo', 'cantidad', 'largo',
        'ancho', 'alto', 'colores', 'texto', 'fecha_inicio',
        'fecha_fin', 'license_id',
    ];

    protected $casts = [
        // 'colocacion' => 'boolean',
        'cantidad' => 'integer',
        'largo' => 'double',
        'ancho' => 'double',
        'alto' => 'double',
        'fecha_inicio' => 'date',
        'fecha_fin' => 'date',
    ];

    public function license()
    {
        return $this->belongsTo(License::class);
    }

    // public function getColocacionAttribute($attribute)
    // {
    //     return $attribute == true ? 'Colocación' : 'Renovación';
    // }
}
