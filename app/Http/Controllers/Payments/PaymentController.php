<?php

namespace App\Http\Controllers\Payments;

use App\Http\Controllers\Controller;
use App\Models\License;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PaymentController extends Controller
{

    public function syncOrders(Request $request)
    {
        collect($request)->map(function($orderFolio){

        });
    }

    public function store(Request $request)
    {
        if ($request->codigo == 0 || $request->codigo == 3) {
            //order save auth payment
            self::insertPaid($request);
            //signature method
        }

        return response()->json($request);
    }

    public function auth()
    {
        $response = Http::acceptJson()
            ->post('http://10.220.103.110:8001/api/login', [
                'name' => 'pruebaapi',
                'password' => 'pruebaapi'
            ]);

        abort_if(!$response->successful(),500,'Error de autenticacion (API), intentelo más tarde.');

        $response = (json_decode($response));
        return $response->token;
    }

    public function insertPaid($order)
    {
        $response = Http::acceptJson()
            ->post('http:/1NCcAefsdpmaVh8mV5NzxVFJFevyjckc2P', [
                'folio' => $order->folio_api,
            ]);

        abort_if(!$response->successful(),500,'Error de actualización (API), intentelo más tarde.');

        $response = (json_decode($response));
        return $response;
    }

    public function queryPaid($order)
    {
        $response = Http::acceptJson()
            ->post('http:/1NCcAefsdpmaVh8mV5NzxVFJFevyjckc2P', [
                'folio' => $order->folio_api,
            ]);

        abort_if(!$response->successful(),500,'Error de actualización (API), intentelo más tarde.');

        $response = (json_decode($response));
        return $response;
    }
}
