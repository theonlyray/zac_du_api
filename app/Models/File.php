<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;

    const CREATED_AT = 'fecha_registro';
    const UPDATED_AT = 'fecha_actualizacion';

    protected $fillable = [
        'nombre', 'ubicacion', 'url',
    ];

    protected $hidden = [];

    protected $with = [];

    public function fileable()
    {
        return $this->morphTo();
    }
}
