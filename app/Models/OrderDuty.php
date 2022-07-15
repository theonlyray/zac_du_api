<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDuty extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
            'precio', 'cantidad', 'total',
    ];

    protected $hidden = [];

    protected $casts = [
        'precio' => 'double',
        'cantidad' => 'double',
        'total' => 'double',
    ];

    protected $with = [];
}
