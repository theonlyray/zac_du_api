<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Hash;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    protected $flagRole, $flagDepartment, $flagCollege;
    public function __construct()
    {
        $this->flagRole         = false;
        $this->flagDepartment   = true;
        $this->flagCollege      = true;
    }

    //?user cann't read data from another user with more privileges than him
    /**
     * @param User requesting $user
     * @param $ability string name of the ability
     * @param $model
     * @param $idsArray array data, index, show, store, contents ids; update contents arrays of data// [0] = roles ids, [1] = departments ids, [2] = colleges ids
     * @return Response null to continue with the next ability to check permissions (user->can())
     */
    public function before(User $user, $ability, $model, $validatingData)
    {
        // logger($validatingData);
        if ($ability == 'index' || $ability == 'show'){
            self::setRoleFlag($user, $validatingData);
        }
        if ($ability == 'store') {
            $storingUser = $validatingData;

            self::setRoleFlag($user, $storingUser->role_id);

            if ($storingUser->department_id != 'null') {//?department
                if ($user->hasRole(['directorCol','subDirectorCol','colaboradorCol'])) {//?college traing to save mpio user
                    $this->flagDepartment = false;
                }else{//?is mpio user, checking dep
                    $requestingUserDepIds   = $user->department->pluck('id')->toArray();
                    self::setDepFag($requestingUserDepIds, [$storingUser->department_id]);
                }
            }
            if ($storingUser->college_id != 'null') {//?department
                if ($user->hasRole(['directorDpt','subDirectorDpt','jefeUnidadDpt','colaboradorDpt'])) {//?mpio traing to save col user
                    $this->flagCollege = false;
                }else{//?is col user, checking col
                    $requestingUserDepIds   = $user->college->pluck('id')->toArray();
                    self::setColFag($requestingUserDepIds, [$storingUser->college_id]);
                }
            }
        }
        if ($ability == 'update' || $ability == 'permissions') {
            $updatingUser = $validatingData;
            //?set in an array updating user rolesIds
            $updatingUserRolesIds = $updatingUser->roles->pluck('id')->toArray();
            //?get the minor id
            $minorupdatingUserId = min($updatingUserRolesIds);

            self::setRoleFlag($user, $minorupdatingUserId);

            if ($updatingUser->hasRole(['directorDpt','subDirectorDpt','jefeUnidadDpt','colaboradorDpt',])) {
                $requestingUserDepIds   = $user->department->pluck('id')->toArray();
                $updatingUserDepsIds    = $updatingUser->department->pluck('id')->toArray();
                self::setDepFag($requestingUserDepIds, $updatingUserDepsIds);
            }

            if ($updatingUser->hasRole(['directorCol','subDirectorCol','colaboradorCol'])) {
                $requestingUserColIds   = $user->college->pluck('id')->toArray();
                $updatingUserColsIds    = $updatingUser->college->pluck('id')->toArray();
                self::setColFag($requestingUserColIds, $updatingUserColsIds);
            }
        }
        return null;
    }

    public function setRoleFlag(User $user, $roleId)
    {
        if ($roleId >= 9 && $user->hasRole(['directorDpt', 'subDirectorDpt', 'jefeUnidadDpt', 'colaboradorDpt'])) {
            $this->flagRole = true;
        }
        else if ($roleId == 5 && $user->hasRole(['directorDpt', 'subDirectorDpt', 'jefeUnidadDpt'])) {//?colaborador
            $this->flagRole = true;
        }
        else if ($roleId == 4 && $user->hasRole(['directorDpt', 'subDirectorDpt'])) {//?jefe uni
            $this->flagRole = true;
        }
    }

    public function setDepFag($requestingUserDepIds, $updatingUserDepsIds)
    {
        if (count(array_intersect($requestingUserDepIds, $updatingUserDepsIds)) == 0)
            $this->flagDepartment = false;
    }

    public function setColFag($requestingUserColIds, $updatingUserColsIds)
    {
        if (count(array_intersect($requestingUserColIds, $updatingUserColsIds)) == 0)
            $this->flagCollege = false;
    }


    public function index(User $user)
    {
        return $user->can('user.index') && $this->flagRole
            ? Response::allow()
            : Response::deny('No tienes permisos para consultar este tipo de usuarios.');
    }

    public function show(User $user)
    {
        return $user->can('user.show') && $this->flagRole
            ? Response::allow()
            : Response::deny('No tienes permisos para consultar los detalles de este usuario.');
    }

    public function store(User $user)
    {
        return $user->can('user.store') && $this->flagRole && $this->flagDepartment && $this->flagCollege
            ? Response::allow()
            : Response::deny('No tienes permisos para crear usuarios.');
    }

    public function update(User $user)
    {
        return $user->can('user.update') && $this->flagRole && $this->flagDepartment && $this->flagCollege
            ? Response::allow()
            : Response::deny('No tienes permisos para actualizar los datos de este usuario.');
    }

    public function permissions(User $user)
    {
        return $user->can('user.permissions') && $this->flagRole && $this->flagDepartment && $this->flagCollege
            ? Response::allow()
            : Response::deny('No tienes permisos para actualizar los permisos de este usuario.');
    }

    //! not implemented, till revision 1.0
    // public function destroy(User $user, int $roleId, string $sadminPassword)
    // {
    //     //?User cann't edit user with more privileges than him
    //     $userRoleId = $user->roles()->get()[0]->id; //?role id from user that made the request
    //     $validPassword = Hash::check($sadminPassword, $user->contrasenia);

    //     return $validPassword && $user->can('users.destroy') && $userRoleId < $roleId //? minor id has more privileges
    //         ? Response::allow()
    //         : Response::deny('No tienes permisos para eliminar el departamento.');
    // }
}
