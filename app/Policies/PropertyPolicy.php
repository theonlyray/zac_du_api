<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class PropertyPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    protected $flagRole, $flagOwner;
    public function __construct()
    {
        $this->flagRole = true;
        $this->flagOwner = true;
    }

    function before(User $user, $ability, $model, $idsArray = null)
    {
        if ($ability == 'show') {
            if($user->hasRole(['dro', 'particular'])){
                if($model->user_id != $user->id) $this->flagOwner = false;
            }
        }

        if ($ability == 'getPropertyByUser') {
            //?set in an array reqeusting user rolesIds
            $requestingUserRolesIds = $user->roles->pluck('id')->toArray();
            //?get the minor id
            $minorRequestingUserId = min($requestingUserRolesIds);

            //?set in an array editing user rolesIds
            $editingUserRolesIds = $idsArray->pluck('id')->toArray();
            //?get the minor id
            $minorEditingUserId = min($editingUserRolesIds);

            if ($minorEditingUserId < $minorRequestingUserId){//? minor id has more privileges than the mayor id
                $this->flagRole = false;
            }
        }
    }

    public function index(User $user)
    {
        return $user->can('property.index')
            ? Response::allow()
            : Response::deny('No tienes permisos para consultar los predios.');
    }

    public function store(User $user)
    {
        return $user->can('property.store')
            ? Response::allow()
            : Response::deny('No tienes permisos para generar predios.');
    }

    public function show(User $user)
    {
        return $user->can('property.show') && $this->flagOwner
            ? Response::allow()
            : Response::deny('No tienes permisos para consultar detalles del predio.');
    }

    public function update(User $user)
    {
        return $user->can('property.update')
            ? Response::allow()
            : Response::deny('No tienes permisos para editar este predio.');
    }

    /**
     * Get property data by user id
     */
    public function getPropertyByUser(User $user){
        return $user->can('property.show') && $this->flagRole
            ? Response::allow()
            : Response::deny('No tienes permisos para consultar este predio.');
    }
}
