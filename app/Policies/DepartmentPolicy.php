<?php

namespace App\Policies;

use App\Models\Department;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Hash;

class DepartmentPolicy
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
        return $user->can('department.index')
            ? Response::allow()
            : Response::deny('No tienes permisos para consultar los departamentos.');
    }

    public function store(User $user)
    {
        return $user->can('department.store')
            ? Response::allow()
            : Response::deny('No tienes permisos para generar departamentos.');
    }

    public function show(User $user)
    {
        return $user->can('department.show')
            ? Response::allow()
            : Response::deny('No tienes permisos para consultar detalles del departamento.');
    }

    public function update(User $user)
    {
        return $user->can('department.update')
            ? Response::allow()
            : Response::deny('No tienes permisos para editar departamentos.');
    }

    public function destroy(User $user, Department $department, string $sadminPassword)
    {
        $validPassword = Hash::check($sadminPassword, $user->contrasenia);

        return $validPassword && $user->can('department.destroy')
            ? Response::allow()
            : Response::deny('No tienes permisos para eliminar departamentos.');
    }
}
