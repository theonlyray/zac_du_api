<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Property extends Model
{
    use HasFactory;
    // , LogsActivity;

    protected $table = 'property_descriptions';

    const CREATED_AT = 'fecha_registro';
    const UPDATED_AT = 'fecha_actualizacion';
    protected $fillable = [
        'calle','no','colonia','seccion','manzana','lote','no_predial',
        'clave_catastral','sup_terreno','sup_construida','sup_no_construida',
        'latitud','longitud','mapa_ubicacion','mapa_url','croquis_ubicacion',
        'croquis_url','escrituras_ubicacion','escrituras_url','predial_ubicacion',
        'predial_url','fachada_ubicacion','fachada_url','panoramica_ubicacion',
        'panoramica_url','fecha_registro','fecha_actualizacion',
    ];

    protected $hidden = [];

    protected $casts = [
        'fecha_registro' => 'datetime',
        'fecha_actualizacion' => 'datetime',
    ];

    protected $with = [];

    // public function getActivitylogOptions(): LogOptions
    // {
    //     return LogOptions::defaults()
    //     ->logOnly(['*'])
    //     ->setDescriptionForEvent(fn(string $eventName) => "{$this->clave_catastral}'s data has been {$eventName}")
    //     ->useLogName('Predios')
    //     ->logOnlyDirty() //?Logging only the changed attributes
    //     ->dontSubmitEmptyLogs();
    // }

    /**
    * Get the user associated with the property.
    */
    // public function user()
    // {
    //     return $this->belongsTo(User::class);
    // }

    /**
    * Get the licenses associated with the property.
    */
    // public function licenses()
    // {
    //     return $this->hasMany(License::class);
    // }

    /*
    *Get the properties by user role
    */
    // public static function getPropertiesByUserRole(User $user)
    // {
    //     $properties = [];
    //     if(!$user->hasRole(['dro', 'particular'])){//?superadmin, mpio
    //         $properties = self::with('user')->get();
    //     }else{//? dro, particular
    //         $properties = self::where('user_id', $user->id)->get();
    //     }
    //     return $properties;
    // }

    public function license()
    {
        return $this->belongsTo(License::class);
    }
}
