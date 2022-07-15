<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class RolePolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function index(User $user)
    {
        return $user->can('role.index')
            ? Response::allow()
            : Response::deny('No tienes permisos para consultar los roles.');
    }

    public function permissionsIndex(User $user)
    {
        return $user->can('permission.index')
            ? Response::allow()
            : Response::deny('No tienes permisos para consultar los permisos.');
    }

    public function update(User $user)
    {
        return $user->can('role.update')
            ? Response::allow()
            : Response::deny('No tienes permisos para editar los roles.');
    }
}
