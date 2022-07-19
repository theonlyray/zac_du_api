<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class UnitPolicy
{
    use HandlesAuthorization;

    protected $flag;
    public function __construct()
    {
        $this->flag = true;
    }

    //?units crud is only accessible for records from the same department
    public function before(User $user, $ability, $model, $unitIdInRequest = null)
    {
       //?set in an array departmentIds
       $userDepartmentIds = $user->department->pluck('id')->toArray();

       if ($ability == 'show') {
           //?user is a public servant and dont belongs to the department
           if(!in_array($unitIdInRequest, $userDepartmentIds)) $this->flag = false;
        }else if($ability == 'store' || $ability == 'update'){
            if(!in_array($unitIdInRequest, $userDepartmentIds)) $this->flag = false;
        }
        return null;//?returns null to continue with the next method
    }

    public function index(User $user)
    {
        return $user->can('unit.index')
            ? Response::allow()
            : Response::deny('No tienes permisos para consultar las Unidades.');
    }

    public function show(User $user)
    {
        return $user->can('unit.show')
            ? Response::allow()
            : Response::deny('No tienes permisos para consultar esta Unidad.');
    }

    public function store(User $user)
    {
        return $user->can('unit.store') && $this->flag
            ? Response::allow()
            : Response::deny('No tienes permisos para crear Unidades.');
    }

    public function update(User $user)
    {
        return $user->can('unit.update') && $this->flag
            ? Response::allow()
            : Response::deny('No tienes permisos para actualizar esta Unidad.');
    }
}
