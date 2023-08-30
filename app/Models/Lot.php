<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lot extends Model
{
    use HasFactory;

    protected $fillable = [
        'colonia', 'seccion', 'manzana', 'lote',
        'propietario', 's_f_d_id',
        'clave_catastral', 'sup_terreno', 'license_id',
    ];

    protected $casts = [
        'sup_terreno' => 'double',
    ];

    public function license()
    {
        return $this->belongsTo(License::class);
    }

    public function sfd()
    {
        return $this->belongsTo(SFD::class);
    }
}
