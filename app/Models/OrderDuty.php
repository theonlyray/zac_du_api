<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDuty extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'monto','precio', 'cantidad', 'cuenta',
        'total', 'idCuenta', 'descripcion'
    ];

    protected $hidden = [];

    protected $casts = [
        'monto' => 'double',
        'precio' => 'double',
        'cantidad' => 'double',
        'total' => 'double',
    ];

    protected $with = [];
}
