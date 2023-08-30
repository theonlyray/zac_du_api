<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\DestroyUserRequest;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Models\CollegeUser;
use App\Models\DepartmentUser;
use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;

class UserController extends Controller
{

    public function index()
    {
        $roleId = request()->query('role_id');

        $this->authorize('index', [User::class, $roleId]);

        $user = request()->user();

        switch ($roleId) {
            case 2: $roleName = 'directorDpt'; break;
            case 3: $roleName = 'subDirectorDpt'; break;
            case 4: $roleName = 'jefeUnidadDpt'; break;
            case 5: $roleName = 'colaboradorDpt'; break;
            case 6: $roleName = 'directorCol'; break;
            case 7: $roleName = 'subDirectorCol'; break;
            case 8: $roleName = 'colaboradorCol'; break;
            case 9: $roleName = 'dro'; break;
            case 10: $roleName = 'particular'; break;

            default: $roleName = 'dro'; break;
        }

        logger($roleName);
        $users = $user->getUsersByRole($roleName);

        abort_if($users->isEmpty(), 204, 'No se encontraron usuarios.');

        return response()->json($users, 200);

    }

    public function show(User $user)
    {
        $this->authorize('show', [User::class, [$user->roles[0]->id]]);
        $user->load(
            [ 'applicantData','specialties',
                'college','department','file',
                'roles', 'unit' ]);

        $user->getAllPermissions();

        return response()->json($user, 200);
    }

    public function store(StoreUserRequest $request)
    {
        $this->authorize('store', [User::class, $request]);

        $requestingUser = request()->user();

        $userDataToCreate = array_merge($request->validated(), [
            'contrasenia' => Hash::make($request->contrasenia),
        ]);


        $userToCreate = new User($userDataToCreate);

        DB::beginTransaction();

        try {
            $userToCreate->save();
            $userToCreate->assignRole($userDataToCreate['role_id']);

            if (!is_null($request->department_id)) {
                $departmentUserData = [
                    'user_id' => $userToCreate->id,
                    'department_id' => $request->department_id,
                ];
                $departmentUser = new DepartmentUser($departmentUserData);
                $departmentUser->save();
            }
            //save unit
            if($request->has('unit_id')){//?sync role
                $userToCreate->unit()->sync([$request->unit_id]);
            }

            if (!is_null($request->college_id)) {
                $collegeUserData = [
                    'user_id' => $userToCreate->id,
                    'college_id' => $request->college_id,
                ];
                $collegeUser = new CollegeUser($collegeUserData);
                $collegeUser->save();
            }


        } catch (\Throwable $th) {
            DB::rollBack();
            abort(500, 'No se ha creado el usuario, inténtalo más tarde. '. $th);
        }

        DB::commit();

        return response()->json($userToCreate->load('roles','department', 'unit' ,'college'), 200);
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $this->authorize('update', [User::class, $user]);

        $rusr = request()->user();
        $user->fill(Arr::except(
            $request->validated(),
            ['contrasenia']
        ));

        if ($request->has('contrasenia')) {//?setting new password
            $newHashedPassword = Hash::make($request->contrasenia);
            $user->contrasenia = $newHashedPassword;
        }

        DB::beginTransaction();

        try {
            $user->save();

            if($request->has('role_id')){//?sync role
                $user->syncRoles([$request->role_id]);
            }

            if($request->has('unit_id')){//?sync role
                $user->unit()->sync([$request->unit_id]);
            }

            if($request->has('dep_id')){//?sync dep
                $user->department()->sync([$request->dep_id]);
            }

	        if ($user->hasRole(['dro']) && ($rusr->hasRole(['directorCol']) ||
                $rusr->hasRole(['subDirectorCol']) || $rusr->hasRole(['colaboradorCol']))) {
                $colData = CollegeUser::firstWhere('user_id', $user->id);
                $colData->validado = $request->validado_col;
                $colData->save();
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            abort(500, 'No se actualizado el usuario, intentelo más tarde. '.$th->getMessage());
        }

            DB::commit();

        return response()->json($user->load('roles','department', 'unit' ,'college'), 200);
    }

    public function permissions(UpdateUserRequest $request, User $user)
    {
        $this->authorize('permissions', [User::class, $user]);

        DB::beginTransaction();

        try {
            if($request->has('role_id')){//?sync role
                $user->syncRoles([$request->role_id]);
            }

            if (!is_null($request->permissions)) {
                $permissionsList = collect($request->permissions)->pluck('id')->toArray();
                $user->syncPermissions($permissionsList);
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            abort(500, 'No se actualizado el usuario, intentelo más tarde. '.$th->getMessage());
        }

            DB::commit();

        return response()->json($user, 200);
    }
}
