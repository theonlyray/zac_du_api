<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SelfBuild extends Model
{
    use HasFactory;

    protected $fillable = [
        'tipo_obra', 'construction',
        'nivel', 'coadyuvante',
        'sup_total','calle','colonia','propietario',
    ];

    public function license()
    {
        return $this->belongsTo(License::class);
    }
}
