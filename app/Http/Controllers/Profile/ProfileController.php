<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Http\Requests\Profile\UpdateProfileRequest;
use App\Http\Requests\Profile\UpdateSpecialtiesRequest;
use App\Models\ApplicantData;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function index()
    {
        $user = request()->user();
        $user = $user->load(['applicantData', 'college', 'specialties', 'department', 'unit', ]);
        $user->getAllPermissions();
        return response()->json($user, 200);
    }

    public function update(UpdateProfileRequest $request)
    {
        $user = $request->user();

        $user->fill(Arr::except( $request->validated(), ['contrasenia'] ));

        if ($request->has('contrasenia')) {
            $newHashedPassword = Hash::make($request->contrasenia);
            $user->contrasenia = $newHashedPassword;
        }

        DB::beginTransaction();

        try {
            $user->save();

            if ($user->hasRole(['dro', 'particular'])) {
                $dataUser = ApplicantData::firstWhere('user_id', $user->id);
                $dataUser->fill($request->input('applicant_data'));
                $dataUser->save();
            }
            // if ($request->hasFile('avatar')) {
            //     $newAvatarUrl = $this->storage->uploadFile(
            //         $request->file('avatar'),
            //         'usuarios/' . $user->id . '/avatar',
            //         null,
            //     );

            //     $user->avatar = $newAvatarUrl['url'];
            // }
        } catch (\Throwable $th) {
            DB::rollBack();
            abort(500, 'No se han realizado los cambios. '.$th);
        }
        DB::commit();

        return response()->json($user->load([ 'roles', 'applicantData', 'college', 'specialties', 'department' ]), 200);
    }
}
