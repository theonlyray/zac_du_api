<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SFD extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'descripcion', 'medidas_colindancia',
        'm2_ocupacion', 'license_id', 'observaciones',
        'actividad',' sustento'
    ];

    protected $casts = [
        'm2_ocupacion' => 'double',
    ];

    public function license()
    {
        return $this->belongsTo(License::class);
    }

    public function lots()
    {
        return $this->hasMany(Lot::class);
    }
}
