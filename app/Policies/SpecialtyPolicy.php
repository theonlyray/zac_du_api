<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class SpecialtyPolicy
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
        return $user->can('specialty.index')
            ? Response::allow()
            : Response::deny('No tienes permisos para consultar las especialidades.');
    }

    public function store(User $user, $specialty)
    {
        $flag = false;
        //?find id in colleges array of user
        foreach ($user->colleges as $college)
            if ($college->id == $specialty['college_id']) $flag = true;


        return $user->can('specialty.store') && $flag
            ? Response::allow()
            : Response::deny('No tienes permisos para crear especialidades.');
    }

    public function show(User $user)
    {
        return $user->can('specialty.show')
            ? Response::allow()
            : Response::deny('No tienes permisos para consultar esta especialidad.');
    }

    //?only users that belong to the college can update it
    public function update(User $user, $specialty)
    {
        $flag = false;
        //?find id in colleges array of user
        foreach ($user->colleges as $college)
            if ($college->id == $specialty['college_id']) $flag = true;

        return $user->can('specialty.update') && $flag
            ? Response::allow()
            : Response::deny('No tienes permisos para actualizar esta especialidad.');
    }
}
