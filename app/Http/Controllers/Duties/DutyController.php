<?php

namespace App\Http\Controllers\Duties;

use App\Http\Controllers\Controller;
use App\Http\Requests\Duty\DestroyDutyRequest;
use App\Http\Requests\Duty\StoreDutyRequest;
use App\Http\Requests\Duty\UpdateDutyRequest;
use App\Models\DepartmentUser;
use App\Models\Duty;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class DutyController extends Controller
{
    public function index()
    {
        $department = request()->query('department');

        $this->authorize('index', [Duty::class, $department]);

        $user = request()->user();

        // //?auth in api
        // self::auth($user);

        // //?query duties null now
        // $apiDuties = self::getDuties($user);

        if ($user->hasRole('jefeSDUMA')) $department = 0;
        $duties = Duty::getDutiesByDepartmentIdAndUserRole(
            $department,
            request()->user()
        );
        if (!empty($duties)) return response()->json($duties, 200);

        abort(204, 'No se encontraron derechos.');
    }

    public function show(Duty $duty)
    {
        $this->authorize('index', [Duty::class, $duty->department_id]);

        return response()->json($duty->load('department'), 200);
    }

    public function store(StoreDutyRequest $request)
    {
        $dutyData = $request->validated();

        $this->authorize('store', [Duty::class, $dutyData['department_id']]);

        $dutyData['precio'] = $dutyData['precio'] / config('app.uma');
        $duty = new Duty($dutyData);

        DB::beginTransaction();

        try {
            $duty->save();

        } catch (\Throwable $th) {
            DB::rollBack();
            abort(500, 'No se ha guardado derecho inténtalo más tarde. '. $th);
        }

        DB::commit();

        return response()->json($duty, 200);
    }

    public function update(UpdateDutyRequest $request, Duty $duty){
        $dutyData = $request->validated();

        $this->authorize('update', [Duty::class, $duty->department_id]);

        DB::beginTransaction();

        try {
            $dutyData['precio'] = $dutyData['precio'] / config('app.uma');
            $duty->update($dutyData);

        } catch (\Throwable $th) {
            DB::rollBack();
            abort(500, 'No se ha guardado el derecho inténtalo más tarde. '. $th);
        }

        DB::commit();

        return response()->json($duty, 200);
    }

    public function auth(User $user)
    {
        $response = Http::acceptJson()
            ->post('http://10.220.103.110:8001/api/login', [
                'name' => 'pruebaapi',
                'password' => 'pruebaapi'
            ]);

        abort_if(!$response->successful(),500,'Error de autenticacion (API), intentelo más tarde.');

        $response = (json_decode($response));

        $depData = DepartmentUser::firstWhere('user_id', $user->id);
        $depData->fill(['api_op_token' =>$response->token]);
        $depData->save();
    }

    public function getDuties(User $user)
    {
        $usrData = DepartmentUser::select('api_op_token')->firstWhere('user_id', $user->id);
        $token = $usrData->api_op_token;

        $response = Http::withHeaders([
                'Authorization' => "Bearer {$token}",
            ])
            ->acceptJson()
            ->get('http://10.220.103.110:8001/api/orden/getCuentas');

        abort_if(!$response->successful(),500,'Error de consulta (API), intentelo más tarde.');

        $response = (json_decode($response));

        return $response->data;
    }

    //!not documented
    // public function destroy(DestroyDutyRequest $request, Duty $duty)
    // {

    //     $this->authorize('destroy', [Duty::class, $duty->department_id, $request->contrasenia]);

    //     DB::beginTransaction();

    //     try {
    //         $duty->delete();

    //     } catch (\Throwable $th) {
    //         DB::rollBack();
    //         abort(500, 'No se ha eliminado el derecho inténtalo más tarde. '. $th);
    //     }

    //     DB::commit();

    //     return response()->json($duty, 200);
    // }
}
