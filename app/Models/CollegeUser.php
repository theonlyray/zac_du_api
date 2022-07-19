<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CollegeUser extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'validado', 'user_id', 'college_id'
    ];

    protected $casts = [
        'validado' => 'boolean',
    ];

}
