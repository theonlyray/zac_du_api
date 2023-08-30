<?php

namespace App\Policies;

use App\Models\License;
use App\Models\LicenseType;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Hash;

class LicensePolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    protected $flagRole, $flagDepartment, $flagOwner, $flagValidation;
    public function __construct()
    {
        $this->flagRole         = true;
        $this->flagDepartment   = true;
        $this->flagOwner        = true;
        $this->flagValidation   = false;
    }

    function before(User $user, $ability, $model, $licenseData = null){
        if ($ability == 'store' && $user->hasRole('particular')) {
            LicenseType::where('id',$licenseData)//?license type id
           ->where('particular',1)
           ->count() <> 0
              ? $this->flagRole = false : null;
        }
        elseif ($ability == 'show' || $ability == 'update' || $ability == 'requirements') {
            if (!$user->hasRole(['dro','particular'])) {
                //?set in an array departmentIds
                $userDepartmentIds = $user->department->pluck('id')->toArray();
                if (!$user->hasRole(['directorCol','subDirectorCol','colaboradorCol']) &&
                    !in_array(LicenseType::find($licenseData->license_type_id)->department_id, $userDepartmentIds))
                    $this->flagDepartment = false;
            }else {
                $licenseData->user_id <> $user->id ? $this->flagOwner = false : null;
            }
        }
        elseif ($ability == 'validations') {
            switch ($licenseData) {
                case 1:
                    if ($user->hasRole(['dro','particular'])) $this->flagValidation  = true;
                    break;
                case 3://?docs corregidos
                    if ($user->hasRole(['dro','particular'])) $this->flagValidation  = true;
                    break;
                case 4:
                    if ($user->can('license.validateDocsPlans')) $this->flagValidation  = true;
                    break;
                case 6:
                    if ($user->can('license.authorize')) $this->flagValidation  = true;
                    break;
                default:
                    $this->flagValidation   = false;
                    break;
            }
        }
        return null;
    }

    public function index(User $user)
    {
        return $user->can('license.index')
            ? Response::allow()
            : Response::deny('No tienes permisos para consultar el listado de licencias.');
    }

    public function show(User $user)
    {
        return $user->can('license.show') && $this->flagDepartment && $this->flagOwner
            ? Response::allow()
            : Response::deny('No tienes permisos para consultar esta licencia.');
    }

    public function store(User $user)
    {
        return $user->can('license.store') && $this->flagRole
            ? Response::allow()
            : Response::deny('No tienes permisos para generar esta licencia.');
    }

    public function update(User $user)
    {
        return $user->can('license.update') && $this->flagDepartment && $this->flagOwner
            ? Response::allow()
            : Response::deny('No tienes permisos para actualizar esta licencia');
    }

    public function requirements(User $user)
    {
        return $user->can('license.requirements') && $this->flagDepartment && $this->flagOwner
            ? Response::allow()
            : Response::deny('No tienes permisos para actualizar este requisito');
    }

    public function observations(User $user, $sadminPassword)
    {
        if (!is_null($sadminPassword)) $validPassword = Hash::check($sadminPassword, $user->contrasenia);
        else $validPassword = true;

        return $validPassword && $user->can('license.observations')
            ? Response::allow()
            : Response::deny('No tienes permisos para agregar observaciones o tu contraseña es incorrecta.');
    }

    public function validations()
    {
        return $this->flagValidation
            ? Response::allow()
            : Response::deny('No tienes permisos para validar esta étapa.');
    }
}
