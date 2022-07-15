<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SpecialtyUser extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [];
    protected $hidden = [];
    protected $with = ['users', 'specialties'];
    protected $casts = [
        'id' => 'int',
        'validado' => 'boolean',
    ];

    public function users()
    {
        return $this->belongsTo(User::class);
    }

    public function specialties()
    {
        return $this->belongsTo(Specialty::class);
    }
}
