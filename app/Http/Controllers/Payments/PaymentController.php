<?php

namespace App\Http\Controllers\Payments;

use App\Events\ApiOPQueried;
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

    public function store(Request $request)
    {
        $request->fechapago = date_create($request->fechapago);
        $order = Order::firstWhere([
            ['folio_api', $request->referencia],
            ['hash', $request->signature]
        ]);

        $license = License::firstWhere('id',$order->license_id);
        // $license = License::firstWhere('id',1); //?used to tests
        $type    = LicenseType::find($license->license_type_id);

        if ($request->codigo == 0 || $request->codigo == 3) {
            //?comentado poque no existe orden
            $order->no_ref_pago = $request->autorizacion;
            $order->pagada = true;

            $order->save();

            //?comentado para no autorizar
            self::authLicense($license);


            //?comentado para no usar vpn
            $event = event(new ApiOPQueried(null));
            //order save auth payment
            $token = $event[0];
            $inserted = self::insertPaid($order, $token);

            //?queue
            if ($inserted) dispatch(new SignLicense($license));

            if ($this->checkLicenseType->isConstruction($license->license_type_id)) dispatch(new SignPlans($license));
        }

        return view('payment.index',
            [
                'payment' => $request,
                'license' => $license,
                'type'    => $type,
            ]);
    }

    public function syncOrders(UpdatePaymentRequest $request)
    {
        $event = event(new ApiOPQueried(null));
        $token = $event[0];

        collect($request->ordersIds)->map(function($id) use ($token) {
            $paid = self::queryPaid($id,$token);
            logger($paid);
            if (!$paid){
                //? local authorization
                $order = Order::firstWhere([
                    ['folio_api', $id],
                ]);
                $order->pagada = true;
                $order->save();
                $license = License::firstWhere('id',$order->license_id);
                self::authLicense($license);

                //?call sign job
                dispatch(new SignLicense($license));

                if ($this->checkLicenseType->isConstruction($license->license_type_id)) dispatch(new SignPlans($license));

                array_push($this->foliosArray, $license->folio);
            }
        });

        $response = [
            'somePayment' => count($this->foliosArray) > 0,
            'data' => $this->foliosArray
        ];
        return response()->json($response, 200);
    }

    public function insertPaid(Order $order, string $token)
    {
        $response = Http::withHeaders([
            'Authorization' => "Bearer {$token}",
        ])
        ->acceptJson()
        ->post('http://10.220.107.112/api/orden/pago', [
            'folio' => $order->folio_api
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
        ->post('http://10.220.107.112/api/orden/folioCheck', [
            'folio' => $id,
        ]);

        abort_if(!$response->successful(),500,'Error de consulta (API), intentelo más tarde.');

        $response = (json_decode($response));
        return $response->estadoFolio == 'PAGADO' ? true : false;
    }

    public function authLicense(License $license)
    {
        $license->estatus = 7;
        $license->save();
        //? sduma user
        $dirSDUMA = User::role('jefeSDUMA')->get();
        $validition = new LicenseValidation(['user_id' => $dirSDUMA->id, 'descripcion' => $license->estatus]);
        $license->validations()->save($validition);
    }
}
