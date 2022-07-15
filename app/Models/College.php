<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class College extends Model
{
    use HasFactory;

    const CREATED_AT = 'fecha_registro';
    const UPDATED_AT = 'fecha_actualizacion';

    protected $fillable = [
        'nombre', 'correo', 'telefono',
        'ubicacion', 'porcentaje',
        'fecha_registro', 'fecha_actualizacion'
    ];

    protected $with = [];

    protected $casts = [
        'porcentaje' => 'float',
        'fecha_registro' => 'datetime',
        'fecha_actualizacion' => 'datetime',
    ];
    /**
     * Get the users that owns the deparment.
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'college_users', 'college_id', 'user_id');
    }
}
