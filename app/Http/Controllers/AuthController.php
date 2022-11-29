<?php

namespace App\Http\Controllers;

use App\Http\Requests\LogInRequest;
use App\Http\Requests\SignUpRequest;
use App\Models\ApplicantData;
use App\Models\College;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AuthController extends Controller
{

    public function signUp(SignUpRequest $request)
    {
        // Make one array with all the user data to be populated
        $userData = array_merge($request->validated(), [
            'contrasenia' => Hash::make($request->contrasenia),
        ]);

        $user = new User($userData);

        DB::beginTransaction();

        try {
            $user->save();

            $applicantData = new ApplicantData($userData);
            $user->applicantData()->save($applicantData);
            $user->assignRole($userData['role_id']);
            if($userData['role_id'] == 9) $user->college()->attach($userData['college_id']);
            $token = $user->createToken($request->input('dispositivo', 'unknown'))
                ->plainTextToken;

            // Mail::to($user->correo)->queue(new UserRegisteredMail(
            //     $user->nombre,
            //     $user->correo,
            //     $request->contrasenia,
            // )); //todo most be a queue
            // Mail::to($user->correo)->send(new UserRegisteredMail(
            //     $user->nombre,
            //     $user->correo,
            //     $request->contrasenia,
            // ));

        } catch (\Throwable $th) {
            DB::rollBack();
            abort(500,  $th .' No se ha realizar el registro, inténtalo más tarde');
        }

        DB::commit();

        return response()->json(
            [
                'user' => $user->load('roles'),
                'Authorization' => $token,
            ], 200,
            // ['Authorization' => 'Bearer ' . $token]
        );
    }

    public function logIn(LogInRequest $request)
    {
        $user = User::where('correo', $request->correo)->first();

        if (!$user || !Hash::check($request->contrasenia, $user->contrasenia)) {
            abort(403, 'El usuario o la contraseña no son válidos.');
        }
        else if ($user->hasRole(['directorDpt', 'subDirectorDpt', 'jefeUnidadDpt', 'colaboradorDpt']) && !$user->validado) {
            abort(403, 'Tu cuenta ha sido deshabilitada.');
        }

        $token = $user->createToken($request->input('dispositivo', 'unknown'))
            ->plainTextToken;
        $user->getRoleNames();

        return response()->json(
            [ 'user' => $user->load('department', 'college'), 'Authorization' => $token]
            , 200, ['Authorization' => $token]);
    }

    public function logInToken()
    {
        $user = request()->user();

        if (!$user->validado) {
            abort(403, 'Tu cuenta ha sido deshabilitada.');
        }

        return response()->json($user->load('roles', 'department', 'college'), 200);
    }

    public function logOut()
    {
        request()->user()->currentAccessToken()->delete();
        return response()->json([], 200);
    }

    public function getColleges(Request $request)
    {
        $colleges = College::all();

        abort_if($colleges->isEmpty(), 204, "No existen colegios.");

        return response()->json($colleges, 200);
    }

    public function getRoles(Request $request)
    {
        $this->authorize('index', Role::class);

        $user = $request->user();
        if ($user->hasRole(['super-admin'])) {
            $roles = Role::all();
        }else if($user->hasRole(['jefeSDUMA','directorDpt', 'subDirectorDpt',])) {
            $roles = Role::whereIn('name', ['directorDpt','subDirectorDpt', 'jefeUnidadDpt', 'colaboradorDpt'])->get();
        }else if($user->hasRole(['directorCol', 'subDirectorCol',])){
            $roles = Role::whereIn('name', ['subDirectorCol', 'colaboradorCol'])->get();
        }else abort(403, "No tienes permisos para consultar esta información.");

        abort_if($roles->isEmpty(), 204, "No hay roles disponibles actualmente.");

        $roles = $roles->map(function($role){
            return $role->load('permissions');
        });
        return response()->json($roles, 200);
    }

    public function updateRole(Request $request, Role $role)
    {
        $this->authorize('update', Role::class);

        $permissionsList = collect($request->permissions)->pluck('id')->toArray();
        $role->syncPermissions($permissionsList);

        return response()->json($role , 200);
    }

    public function getPermissions()
    {
        $this->authorize('permissionsIndex', Role::class);

        $permissions = Permission::all();

        abort_if($permissions->isEmpty(),204, "No hay permisos actualmente.");

        return response()->json($permissions, 200);
    }
}
