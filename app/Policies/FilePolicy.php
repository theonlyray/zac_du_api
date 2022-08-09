<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Hash;

class FilePolicy
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
        return $user->can('file.index')
            ? Response::allow()
            : Response::deny('No tienes permisos para consultar los archivos.');
    }

    public function store(User $user)
    {
        return $user->can('file.store')
            ? Response::allow()
            : Response::deny('No tienes permisos para cargar archivos.');
    }

    public function show(User $user)
    {
        return $user->can('file.show')
            ? Response::allow()
            : Response::deny('No tienes permisos para consultar detalles del archivo.');
    }

    public function update(User $user)
    {
        return $user->can('file.update')
            ? Response::allow()
            : Response::deny('No tienes permisos para editar archivos.');
    }

    public function destroy(User $user, string $sadminPassword)
    {
        $validPassword = Hash::check($sadminPassword, $user->contrasenia);

        return $validPassword && $user->can('file.destroy')
            ? Response::allow()
            : Response::deny('No tienes permisos para eliminar archivos o tu constraseña es incorrecta.');
    }
}
