<?php

namespace App\Http\Controllers;

use App\Http\Requests\LogInRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Http\Requests\SignUpRequest;
use App\Mail\ResetPasswordMail;
use App\Models\AdDescription;
use App\Models\ApplicantData;
use App\Models\College;
use App\Models\CompatibilityCertificate;
use App\Models\ConstructionBackground;
use App\Models\ConstructionDescription;
use App\Models\ConstructionOwner;
use App\Models\Credential;
use App\Models\Department;
use App\Models\File;
use App\Models\License;
use App\Models\LicenseObservation;
use App\Models\LicenseRequirement;
use App\Models\LicenseValidation;
use App\Models\LicenseValidity;
use App\Models\Lot;
use App\Models\Order;
use App\Models\OrderDuty;
use App\Models\SelfBuild;
use App\Models\SFD;
use App\Models\StructuralSafetyCertificate;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Crypt;
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

    public function logOutToken(Request $request)
    {
        $request->user()->tokens()->where('id', $request->id)->delete();
        return response()->json([], 200);
    }

    public function getColleges(Request $request)
    {
        $colleges = College::all();

        abort_if($colleges->isEmpty(), 204, "No existen colegios.");

        return response()->json($colleges, 200);
    }

    public function getDepartments(Request $request)
    {
        $departments = Department::all();

        abort_if($departments->isEmpty(), 204, "No existen deps.");

        return response()->json($departments, 200);
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

    public function docs()
    {
        return File::where([
            ['para', null],
            ['college_id', null],
        ])->get();
    }

    public function resetPassword(ResetPasswordRequest $request)
    {
        try {
            $user = User::where('correo', $request->correo)->firstOrFail();
            $newPassword        = Str::random(16);
            $user->contrasenia  = Hash::make($newPassword);

            abort_if(is_null($user), 204, "El correo no está asociado a ningún usuario.");

            abort_if($user->hasRole(['super-admin', 'jefeSDUMA']),
                500, "Algo salió mal al restaurar la contraseña, inténtalo más tarde");

            if ($user->save()) {
                Mail::to($user->correo)->send(new ResetPasswordMail(
                    $user->nombre,
                    $user->correo,
                    $newPassword,
                ));

                return response()->json("Se ha enviado un correo a la dirección especificada con la nueva contraseña.", 200);
            }

            abort(500, "Algo salió mal al restaurar la contraseña, inténtalo más tarde");
        } catch (ModelNotFoundException $e) {
            abort(204, "El correo no está asociado a ningún usuario.");
        }
    }

    public function license(Request $request)
    {
        //get uuid parameter
        $uuid = request()->query('uuid');
        //decode uuid md5
        $uuid = Crypt::decryptString($uuid);

        $license = License::where('folio', $uuid)->first();

        abort_if(is_null($license), 404, "No se encontró la licencia.");

        return response()->json($license->load([
            'licenseType', 'applicant', 'property',
            'backgrounds', 'construction', 'applicant.applicantData',
        ]), 200);

    }

    public function truncateLicensesTable()
    {
        // $this->authorize('truncate', License::class);

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        AdDescription::truncate();
        CompatibilityCertificate::truncate();
        ConstructionBackground::truncate();
        ConstructionDescription::truncate();
        ConstructionOwner::truncate();
        License::truncate();
        LicenseObservation::truncate();
        LicenseRequirement::truncate();
        LicenseValidation::truncate();
        LicenseValidity::truncate();
        Lot::truncate();
        Order::truncate();
        OrderDuty::truncate();
        SelfBuild::truncate();
        SFD::truncate();
        StructuralSafetyCertificate::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // return response()->json("Se ha vaciado la tabla de licencias.", 200);

        // Order::truncate();
        // $data = Order::all();

        return response()->json('$data', 200);
    }
}
