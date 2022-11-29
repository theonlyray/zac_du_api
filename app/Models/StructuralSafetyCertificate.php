<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StructuralSafetyCertificate extends Model
{
    use HasFactory;

    protected $fillable = [
        'destino', 'license_id',
    ];

    protected $casts = [
        'destino' => 'int',
    ];

    public function license()
    {
        return $this->belongsTo(License::class);
    }
}
