<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class DutyPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    public function index(User $user)
    {
        return $user->can('duty.index')
            ? Response::allow()
            : Response::deny('No tienes permisos para consultar las cuentas.');
    }

    public function show(User $user)
    {
        return $user->can('duty.show')
            ? Response::allow()
            : Response::deny('No tienes permisos para consultar esta cuenta.');
    }
}
