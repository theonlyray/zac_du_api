<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class File extends Model
{
    use HasFactory, LogsActivity;

    const CREATED_AT = 'fecha_registro';
    const UPDATED_AT = 'fecha_actualizacion';

    protected $fillable = [
        'nombre','ubicacion','url','fecha_registro',
        'fecha_actualizacion','para','college_id','user_id',
    ];

    protected $hidden = [];

    protected $with = [];

    protected $casts = [
        // 'para' => 'boolean'
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logOnly(['*'])
        ->setDescriptionForEvent(fn(string $eventName) => "{$this->nombre}'s data has been {$eventName}")
        ->useLogName('Documentos')
        ->logOnlyDirty() //?Logging only the changed attributes
        ->dontSubmitEmptyLogs();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function college()
    {
        return $this->morphTo(College::class);
    }

    public static function getFilesByRole(User $user)
    {
        if ($user->hasRole(['jefeSDUMA'])) {
            return File::where([
                ['para', '<>', null],
                ['college_id', null],
            ])->get();
        }
        elseif ($user->hasRole(['directorDpt', 'subDirectorDpt', 'jefeUnidadDpt', 'colaboradorDpt'])) {
            return File::where([
                ['para', '<>', null],
                ['college_id', null],
            ])->get();
        }elseif ($user->hasRole(['directorCol','subDirectorCol', 'colaboradorCol'])) {
            $college = $user->college->pluck('id')->toArray();
            return File::where([
                ['para', '<>', null],
                ['college_id', $college[0]]
            ])->get();
        }elseif ($user->hasRole(['dro'])) {
            return File::where('para', true)
                ->where('college_id', $user->college[0]->id)
                ->orWhere('college_id', null)
                // ->with('college')
                ->get();
        }elseif ($user->hasRole(['particular'])) {
            return File::where('para', false)->get();
        }
    }
}
