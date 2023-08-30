<?php

namespace App\Http\Controllers\Duties;

use App\Events\ApiOPQueried;
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
        $this->authorize('index', Duty::class);

        $user = request()->user();

        $event = event(new ApiOPQueried($user));

        //?$event[0] is an api token if user has role jefeSDUMA else is null
        $user->api_op_token = $event[0];

        $apiDuties = self::getDuties($user);

	    abort_if(empty($apiDuties), 204, 'No se encontraron cuentas.');
        return response()->json($apiDuties, 200);
    }

    public function show(Duty $duty)
    {
        $this->authorize('index', Duty::class);

        return response()->json($duty->load('department'), 200);
    }

    public function getDuties(User $user)
    {

        // if (!$user->hasRole(['jefeSDUMA'])) {
        //     $usrData = DepartmentUser::select('api_op_token')->firstWhere('user_id', $user->id);
        //     $token = $usrData->api_op_token;
        // }else
        $token = $user->api_op_token;


        $response = Http::withHeaders([
                'Authorization' => "Bearer {$token}",
            ])
            ->acceptJson()
            ->get('https://sefin.capitaldezacatecas.gob.mx/api/orden/getCuentas');

        abort_if(!$response->successful(),500,'Error de consulta (API), intentelo más tarde.');

        $response = (json_decode($response));

        return $response->data;
    }
}
