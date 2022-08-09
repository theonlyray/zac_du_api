<?php

namespace App\Policies;

use App\Models\License;
use App\Models\Order;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Hash;

class OrderPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    protected $flag;
    protected $deletingMessage;
    public function __construct()
    {
        $this->flag = true;
        $this->deletingMessage = 'No tienes permisos para eliminar esta orden.';
    }

    //?order store method is only accessible for users from the same department of the license type
    public function before(User $user, $ability, $model, $departmentIdInRequest = null, License $license = null, Order $order = null, $password = null)
    {
       //?set in an array departmentIds
       $userDepartmentIds = $user->department->pluck('id')->toArray();

       if ($ability == 'index' || $ability == 'show' || $ability == 'update') {
            //?user is a public servant and dont belongs to the department
            if(!$user->hasRole(['dro', 'particular']) && !in_array($departmentIdInRequest, $userDepartmentIds)) $this->flag = false;
            //? user is applicat but doesn owner of license
            if($user->hasRole(['dro', 'particular']) && $user->id != $license->user_id) $this->flag = false;

        }else if($ability == 'store' || $ability == 'validate'){
            if(!in_array($departmentIdInRequest, $userDepartmentIds)) $this->flag = false;
        }elseif ($ability == 'destroy') {
            if(!in_array($departmentIdInRequest, $userDepartmentIds)) $this->flag = false;
            if($order->pagada){
                $this->deletingMessage = 'No puedes eliminar una orden pagada.';
                $this->flag = false;
            }
            if (!Hash::check($password, $user->contrasenia)) {
                $this->deletingMessage = 'Contraseña incorrecta.';
                $this->flag = false;
            }
        }
        return null;//?returns null to continue with the next method
    }

    public function index(User $user)
    {
        return $user->can('order.index') && $this->flag
            ? Response::allow()
            : Response::deny('No tienes permisos para consultar esta orden.');
    }

    public function show(User $user)
    {
        return $user->can('order.show') && $this->flag
            ? Response::allow()
            : Response::deny('No tienes permisos para consultar esta orden.');
    }

    public function store(User $user)
    {
        return $user->can('order.store') && $this->flag
            ? Response::allow()
            : Response::deny('No tienes permisos para generar ordenes.');
    }

    public function update(User $user)
    {
        return $user->can('order.update') && $this->flag
            ? Response::allow()
            : Response::deny('No tienes permisos para actualizar esta orden.');
    }

    public function destroy(User $user)
    {
        return $user->can('order.destroy') && $this->flag
            ? Response::allow()
            : Response::deny($this->deletingMessage);
    }

    public function validate(User $user)
    {
        return $user->can('order.validate') && $this->flag
            ? Response::allow()
            : Response::deny('No tienes permisos para validar ordenes.');
    }
}
