<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DepartmentUser extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'api_op_token',
        'department_id', 'user_id',
    ];

    /**
     * Get the user that owns the data.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
