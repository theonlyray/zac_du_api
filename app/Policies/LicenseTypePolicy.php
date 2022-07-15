<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class LicenseTypePolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    protected $flag;
    public function __construct()
    {
        $this->flag = true;
    }

    //?license type crud is only accessible for records from the same department
    //?applicat only can read
    public function before(User $user, $ability, $model, $departmentIdInRequest = null)
    {
       //?set in an array departmentIds
       $userDepartmentIds = $user->department->pluck('id')->toArray();

       if ($ability == 'show') {
           //?user is a public servant and dont belongs to the department
           if(!$user->hasRole(['dro', 'particular']) && !in_array($departmentIdInRequest, $userDepartmentIds)) $this->flag = false;
        }else if($ability == 'store' || $ability == 'update'){
            if(!in_array($departmentIdInRequest, $userDepartmentIds)) $this->flag = false;
        }
        return null;//?returns null to continue with the next method
    }

    public function index(User $user)
    {
        return $user->can('licenseType.index')
            ? Response::allow()
            : Response::deny('No tienes permisos para consultar los tipos de licencias.');
    }

    public function show(User $user)
    {
        return $user->can('licenseType.show')
            ? Response::allow()
            : Response::deny('No tienes permisos para consultar este tipo de licencias.');
    }

    public function store(User $user)
    {
        return $user->can('licenseType.store') && $this->flag
            ? Response::allow()
            : Response::deny('No tienes permisos para crear tipos de licencias.');
    }

    public function update(User $user)
    {
        return $user->can('licenseType.update') && $this->flag
            ? Response::allow()
            : Response::deny('No tienes permisos para actualizar este tipo de licencia.');
    }
}
