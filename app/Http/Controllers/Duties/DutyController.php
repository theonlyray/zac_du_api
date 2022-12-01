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

        // $user = request()->user();

        // $event = event(new ApiOPQueried($user));

        // //$event[0] is an api token if user has role jefeSDUMA else is null
        // $user->api_op_token = $event[0];

        // $apiDuties = self::getDuties($user);

        // if (!empty($apiDuties)) return response()->json($apiDuties, 200);

        return response()->json(
            collect([
                ["cuenta" => 4211,"subcuenta" => 1,"Descripcion" => "NUMERO OFICIAL","id" => 24,"idCuenta"=> 5,"monto" => 385],
                ["cuenta" => 4211,"subcuenta" => 1,"Descripcion" => "ALINEAMIENTO","id" => 25,"idCuenta"=> 5,"monto" => 385],
                ["cuenta" => 4201,"subcuenta" => 2,"Descripcion" => "PRORROGAS","id" => 26,"idCuenta"=> 208,"monto" => 385],
                ["cuenta" => 4201,"subcuenta" => 4,"Descripcion" => "TRABAJOS MENORES","id" => 27,"idCuenta"=> 155,"monto" => null],
                ["cuenta" => 4201,"subcuenta" => 4,"Descripcion" => "ENJARRES Y APLANADOS, FIRMES, COLOCACION DE PISO, YESO, PETATILLO, TABLAROCA, CANCELERIA, ENMALLADO","id" => 28,"idCuenta"=> 155,"monto" => null],
                ["cuenta" => 4201,"subcuenta" => 4,"Descripcion" => "DEMOLICION","id" => 29,"idCuenta"=> 155,"monto" => null],
                ["cuenta" => 4201,"subcuenta" => 4,"Descripcion" => "MURO DE CONTENCION (HASTA 3 M ALTURA)","id" => 30,"idCuenta"=> 155,"monto" => null],
                ["cuenta" => 4201,"subcuenta" => 4,"Descripcion" => "CIMENTACION","id" => 31,"idCuenta"=> 155,"monto" => null],
                ["cuenta" => 4201,"subcuenta" => 4,"Descripcion" => "TECHUMBRES","id" => 32,"idCuenta"=> 155,"monto" => null],
                ["cuenta" => 4201,"subcuenta" => 7,"Descripcion" => "PERMISO PARA ROMPER PAVIMIENTO, SOLICITUD DE JIAPAZ (HASTA 5 ML)","id" => 33,"idCuenta"=> 189,"monto" => null],
                ["cuenta" => 4201,"subcuenta" => 6,"Descripcion" => "CONSTANCIAS VARIAS","id" => 34,"idCuenta"=> 61,"monto" => 385],
                ["cuenta" => 4201,"subcuenta" => 6,"Descripcion" => "CONSTANCIA DE SERVICIOS URBANOS","id" => 35,"idCuenta"=> 61,"monto" => 673],
                ["cuenta" => 4201,"subcuenta" => 9,"Descripcion" => "CONSTANCIA SEGURIDAD ESTRUCTURAL","id" => 36,"idCuenta"=> 66,"monto" => 770],
                ["cuenta" => 4201,"subcuenta" => 10,"Descripcion" => "CONSTANCIA DE AUTOCONSTRUCCION","id" => 37,"idCuenta"=> 62,"monto" => 673],
                ["cuenta" => 4201,"subcuenta" => 6,"Descripcion" => "CONSTANCIA DRO","id" => 38,"idCuenta"=> 61,"monto" => 577],
                ["cuenta" => 4201,"subcuenta" => 4,"Descripcion" => "PERMISO DE CONSTRUCCION","id" => 39,"idCuenta"=> 155,"monto" => null],
                ["cuenta" => 4201,"subcuenta" => 8,"Descripcion" => "PERMISO P\/MOVIMIENTO DE ESCOMBRO","id" => 40,"idCuenta"=> 188,"monto" => null],
                ["cuenta" => 4201,"subcuenta" => 4,"Descripcion" => "KIMPIEZA DE TERRENO Y MOV DE TIERRAS","id" => 41,"idCuenta"=> 155,"monto" => null],
                ["cuenta" => 4201,"subcuenta" => 7,"Descripcion" => "PERMISO PARA ROMPER PAVIMENTO LINEA ELECTRICA","id" => 42,"idCuenta"=> 189,"monto" => 770],
                ["cuenta" => 4201,"subcuenta" => 7,"Descripcion" => "PERMISO PARA ROMPER PAVIMENTO PARA INCORPORACION DE LA RED DE AGUA POTABLE Y DRENAJE","id" => 43,"idCuenta"=> 189,"monto" => 481],
                ["cuenta" => 4201,"subcuenta" => 4,"Descripcion" => "ANTENA DE TELECOMUNICACION","id" => 44,"idCuenta"=> 155,"monto" => null],
                ["cuenta" => 4414,"subcuenta" => 4,"Descripcion" => "REP. ZANJAS TOMA DE AGUA POTABLE","id" => 45,"idCuenta"=> 227,"monto" => null],
                ["cuenta" => 4216,"subcuenta" => 3,"Descripcion" => "ANUNCIOS Y PUBLICIDAD","id" => 46,"idCuenta"=> 13,"monto" => null],
                ["cuenta" => 4201,"subcuenta" => 3,"Descripcion" => "CONSTANCIA DE COMPATIBILIDAD URBANA","id" => 47,"idCuenta"=> 63,"monto" => null],
                ["cuenta" => 4211,"subcuenta" => 12,"Descripcion" => "FUSIONES SUBDIVISIONES DESMEMRACIO","id" => 48,"idCuenta"=> 123,"monto" => null]
            ])
            , 200);

        abort(204, 'No se encontraron cuentas.');
    }

    public function show(Duty $duty)
    {
        $this->authorize('index', Duty::class);

        return response()->json($duty->load('department'), 200);
    }

    public function getDuties(User $user)
    {
        if (!$user->hasRole(['jefeSDUMA'])) {
            $usrData = DepartmentUser::select('api_op_token')->firstWhere('user_id', $user->id);
            $token = $usrData->api_op_token;
        }else $token = $user->api_op_token;


        $response = Http::withHeaders([
                'Authorization' => "Bearer {$token}",
            ])
            ->acceptJson()
            ->get('http://10.220.107.112/api/orden/getCuentas');

        abort_if(!$response->successful(),500,'Error de consulta (API), intentelo más tarde.');

        $response = (json_decode($response));

        return $response->data;
    }
}
