<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnitUser extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'unit_id', 'user_id',
    ];
}
