<?php

namespace App\Http\Controllers\Payments;

use App\Events\ApiOPQueried;
use App\Events\GenerateLicense;
use App\Events\PaidLicense;
use App\Http\Controllers\Controller;
use App\Http\Requests\Payment\UpdatePaymentRequest;
use App\Jobs\SignLicense;
use App\Jobs\SignPlans;
use App\Models\License;
use App\Models\LicenseType;
use App\Models\LicenseValidation;
use App\Models\Order;
use App\Models\User;
use App\Services\CheckLicenseType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class PaymentController extends Controller
{
    public $foliosArray;
    protected $checkLicenseType;

    public function __construct() {
        $this->foliosArray = [];
        $this->checkLicenseType = new CheckLicenseType();
    }

    public function index()
    {
        $uuid = request()->query('uuid');

        $license = License::firstWhere('folio',$uuid);

        return response()->json([
            $license->load(['licenseType','order.duties']),
        ], 200);
    }

    public function store(Request $request)
    {
        $toSign = false;

        $request->fechapago = date_create($request->fechapago);
        $order = Order::firstWhere([
            ['folio_api', $request->referencia],
            // ['hash', $request->signature]
        ]);

        $license = License::firstWhere('id',$order->license_id);
        $type    = LicenseType::find($license->license_type_id);

        if ($request->codigo == 0 || $request->codigo == 3) {
            $order->no_ref_pago = $request->autorizacion;
            $order->pagada = true;

            $order->save();

            $toSign = true;
        }
        if ($request->codigo == 5 && !$license->firmada) {
            $toSign = true;
        }

        if ($toSign) {
            try{
                self::authLicense($license, $order);

                $user = User::find($order->validator_id);

                //order save auth payment
                $event = event(new ApiOPQueried(null));
                $token = $event[0];
                $inserted = self::insertPaid($order,$token);

                //?generate a new update license
                event(new GenerateLicense($license));
                //todo manual chmod to sing service can write on dir
                exec("chmod -R 0777 /var/www/permisos.capitaldezacatecas.gob.mx/api/storage/app/public/solicitantes/{$license->user_id}/licencias/{$license->id}/");

                //?queue sign
                if($inserted){
                    dispatch(new SignLicense($license, $user));
                }
                //? queue sign plans
                if($inserted && ($this->checkLicenseType->isConstruction($license->license_type_id) ||
                    $license->license_type_id == 22)){
                    dispatch(new SignPlans($license, $user));
                }
            }catch (\Throwable $th) {
              abort(500, 'Error '. $th->getMessage());
            }
        }

        return response()->json([
            'payment' => $request->all(),
            'license' => $license,
            'type' => $type,
        ], 200);
    }

    public function syncOrders(UpdatePaymentRequest $request){
        $event = event(new ApiOPQueried(null));
        $token = $event[0];

        collect($request->ordersIds)->map(function($id) use ($token) {
            $paid = self::queryPaid($id,$token);
            if ($paid){

                //? local authorization
                $order = Order::firstWhere([
                    ['folio_api', $id],
                ]);
                $order->pagada = true;
                $order->save();
                $user = User::find($order->validator_id);
                $license = License::firstWhere('id',$order->license_id);

                self::authLicense($license, $order);

                //?generate a new update license
                event(new GenerateLicense($license));
                //todo manual chmod to sing service can write on dir
                exec("chmod -R 0777 /var/www/permisos.capitaldezacatecas.gob.mx/api/storage/app/public/solicitantes/{$license->user_id}/licencias/{$license->id}/");
                //?call sign job
                dispatch(new SignLicense($license, $user));

            if ($this->checkLicenseType->isConstruction($license->license_type_id)) dispatch(new SignPlans($license, $user));
                array_push($this->foliosArray, $license->folio);
            }
        });

        $response = [
            'somePayment' => count($this->foliosArray) > 0,
            'data' => $this->foliosArray
        ];
        return response()->json($response, 200);
    }

    public function insertPaid($order, $token){
	    $response = Http::withOptions([
            'verify' => false,
        ])->acceptJson()
        ->withToken($token)
        ->asForm()->post('https://sefin.capitaldezacatecas.gob.mx/api/orden/pago', [
                "folio" => $order->folio_api
        ]);

        abort_if(!$response->successful(),500,'Error de inserción (API), intentelo más tarde.');

        return $response->getStatusCode() == 200;

    }

    public function queryPaid(int $id, string $token)
    {
        $response = Http::withHeaders([
            'Authorization' => "Bearer {$token}",
        ])
        ->acceptJson()
        ->post('https://sefin.capitaldezacatecas.gob.mx/api/orden/folioCheck', [
            'folio' => $id,
        ]);

        abort_if(!$response->successful(),500,'Error de consulta (API), intentelo más tarde.');

        $response = (json_decode($response));

        return $response->estadoFolio == 'PAGADO' ? true : false;
    }

    public function authLicense(License $license, Order $order)
    {
        $license->estatus = 6;
        $license->save();
        //? sduma user
        // $dirSDUMA = User::role('jefeSDUMA')->get();

        $user = User::find($order->validator_id);
        $validition = new LicenseValidation(['user_id' => $user->id, 'descripcion' => $license->estatus]);

        // $validition = new LicenseValidation(['user_id' => $dirSDUMA[0]->id, 'descripcion' => $license->estatus]);
        $license->validations()->save($validition);
    }
}
