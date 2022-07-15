<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Hash;

class RequirementPolicy
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
    public function before(User $user, $ability, $model, $departmentIdInRequest)
    {
       //?set in an array departmentIds
       $userDepartmentIds = $user->department->pluck('id')->toArray();

       if ($ability == 'index' || $ability == 'show') {
           //?user is a public servant and dont belongs to the department
           if(!$user->hasRole(['dro', 'particular']) && !in_array($departmentIdInRequest, $userDepartmentIds)) $this->flag = false;
        }else if($ability == 'store' || $ability == 'update'){
            if(!in_array($departmentIdInRequest, $userDepartmentIds)) $this->flag = false;
        }
        return null;//?returns null to continue with the next method
    }

    public function index(User $user)
    {
        return $user->can('requirement.index') && $this->flag
            ? Response::allow()
            : Response::deny('No tienes permisos para consultar los requisitos.');
    }

    public function show(User $user)
    {
        return $user->can('requirement.show') && $this->flag
            ? Response::allow()
            : Response::deny('No tienes permisos para consultar este requisito.');
    }

    public function store(User $user)
    {
        return $user->can('requirement.store') && $this->flag
            ? Response::allow()
            : Response::deny('No tienes permisos para crear requisitos');
    }

    public function update(User $user, int $departmentId)
    {
        return $user->can('requirement.update') && $this->flag
            ? Response::allow()
            : Response::deny('No tienes permisos actualizar requisitos.');
    }
}
