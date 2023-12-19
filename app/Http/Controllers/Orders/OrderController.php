<?php

namespace App\Http\Controllers\Orders;

use App\Events\ApiOPQueried;
use App\Events\GenerateLicense;
use App\Http\Controllers\Controller;
use App\Http\Requests\Order\DestroyOrderRequest;
use App\Http\Requests\Order\StoreOrderRequest;
use App\Http\Requests\Order\UpdateOrderPaymentRequest;
use App\Http\Requests\Order\UpdateOrderRequest;
use App\Http\Requests\Order\ValidateOrderRequest;
use App\Models\ApplicantData;
use App\Models\Duty;
use App\Models\File;
use App\Models\License;
use App\Models\LicenseType;
use App\Models\Order;
use App\Models\OrderDuty;
use App\Models\User;
use App\Notifications\OrderValidated;
use App\Services\CheckLicenseType;
use App\Services\StorageService;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class OrderController extends Controller
{
    protected $totalGral;
    protected $storage;
    protected $checkLicenseType;
    public function __construct(StorageService $storage)
    {
        $this->storage = $storage;
        $this->totalGral = 0;
        $this->checkLicenseType = new CheckLicenseType();
    }

    public function index(License $license)
    {
        $department = LicenseType::find($license->license_type_id);

        $this->authorize('index', [Order::class, $department->department_id, $license]);

        //?if user is applicat only can see validated orders
        if (
            (request()->user()->hasRole(['dro', 'particular']) && $license->load('order')['validad']) ||
            !request()->user()->hasRole(['dro', 'particular'])
        ) {
            return response()->json($license->load('order'), 200);
        }
        abort(204, 'No se encontraron ordenes.');
    }

    public function show(License $license, Order $order)
    {
        $department = LicenseType::find($license->license_type_id);

        $this->authorize('show', [Order::class, $department->department_id, $license]);

        //?if user is applicat only can see validated orders
        if (
            (request()->user()->hasRole(['dro', 'particular']) && $order->validada) ||
            !request()->user()->hasRole(['dro', 'particular'])
            ) {
            return response()->json($license->load(['order.duties','order.file']), 200);
        }
        abort(204, 'No se encontraron ordenes.');
    }

    public function store(StoreOrderRequest $request, License $license)
    {
        $department = LicenseType::find($license->license_type_id);

        $this->authorize('store', [Order::class, $department->department_id]);

        $user = $request->user();

        $duties  = collect($request->derechos)->map(function ($duty){
            $duty['total'] = $duty['precio'] * $duty['cantidad'];
            $this->totalGral += $duty['precio'] * $duty['cantidad'];
            return new OrderDuty($duty);
        });
        $order = [
            'total' => $this->totalGral,
            'creator_id' => $user->id,
            'license_id' => $license->id,
        ];
        $order = new Order($order);

        DB::beginTransaction();

        try {
            $order->save();
            $order->duties()->saveMany($duties);

            /**
             * http get request to get online payment qr code and save it
             */
            $response = Http::get(
                "https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=http://permisos.capitaldezacatecas.gob.mx/pagos.html?uuid=$license->folio&choe=UTF-8");
            Storage::put("public/solicitantes/{$license->user_id}/licencias/{$license->id}/pago/qr.png",
                $response->body(), 'public');

        } catch (\Throwable $th) {
            DB::rollBack();
            abort(500, 'No se ha podido generar la orden, intentelo más tarde. '.$th->getMessage());
        }
        DB::commit();

        return response()->json($order, 200);
    }

    public function update(UpdateOrderRequest $request, License $license, Order $order)
    {
        $department = LicenseType::find($license->license_type_id);

        $this->authorize('update', [Order::class, $department->department_id, $license]);

        DB::beginTransaction();

        try {
            $order->no_ref_pago = $request->no_ref_pago ?? $order->no_ref_pago;
            $order->pagada      = $request->pagada ?? $order->pagada;

            if (!$order->validada) {
                OrderDuty::where('order_id', $order->id)->delete();
                $duties  = collect($request->derechos)->map(function ($duty){
                    $duty['total'] = $duty['precio'] * $duty['cantidad'];
                    $this->totalGral += $duty['precio'] * $duty['cantidad'];
                    return new OrderDuty($duty);
                });

                $order->total       = $this->totalGral;
                $order->duties()->saveMany($duties);
            }
            $order->save();
        } catch (\Throwable $th) {
            DB::rollBack();
            abort(500, 'No se ha actualziar la orden de pago inténtalo más tarde. '. $th->getMessage());
        }

        DB::commit();

        return response()->json($order, 200);
    }

    public function updatePayment(UpdateOrderPaymentRequest $request, License $license, Order $order)
    {
        $department = LicenseType::find($license->license_type_id);

        $this->authorize('update', [Order::class, $department->department_id, $license]);

        try {
            $order->file != null ? $this->storage->deleteFiles($order->file->ubicacion) : null;

            $uploadedFile = $this->storage->uploadBase64File(
                $request->pago,
                "public/solicitantes/{$license->user_id}/predios/{$license->property_id}/licencias/{$license->id}/pago",
                'payment'
            );

            $newData['ubicacion'] = $uploadedFile['path'];
            $newData['url'] = $uploadedFile['url'];

            $file = new File($newData);
            $order->file()->save($file);

        } catch (\Throwable $th) {
            abort(500, 'No se ha podido cargar el comprobante, intentelo más tarde.'. $th);
        }
        return response()->json($license->load(['order.duties','order.file']), 200);
    }

    public function destroy(DestroyOrderRequest $request, License $license, Order $order)
    {
        $department = LicenseType::find($license->license_type_id);

        $this->authorize('destroy', [Order::class, $department->department_id, null, $order, $request->contrasenia]);

        DB::beginTransaction();

        try {
            $order->delete();
        } catch (\Throwable $th) {
            DB::rollBack();
            abort(500, 'No se ha eliminado la orden inténtalo más tarde. '. $th->getMessage());
        }

        DB::commit();

        return response()->json($order, 200);
    }

    public function validating(ValidateOrderRequest $request, License $license, Order $order)
    {
        //? user with role jefeSDUMA is as super admin dont enter in validations
        $this->authorize('validate', [Order::class, null, $license, $order, $request->contrasenia]);

        $user = request()->user();

        DB::beginTransaction();
        try {
            $event = event(new ApiOPQueried($user));

            // $event[0] is an api token if user has role jefeSDUMA else is null
            $user->api_op_token = $event[0];
            $response = self::storeOrder($user, $license, $order);

            $order->folio_api   = $response->folio;
            $order->fecha_autorizacion = Carbon::now();
            $order->hash = $response->signatura;
            $order->validada = true;
            $order->validator_id = $user->id;
            $order->save();

            $user = User::find($license->user_id);
            $user->notify(new OrderValidated($license, $order));

            $license->estatus = 5;
            $license->save();

            event(new GenerateLicense($license));
        } catch (\Throwable $th) {
            DB::rollBack();
            logger($th);
            abort(500, 'No se ha validado la orden inténtalo más tarde. '. $th->getMessage());
        }

        DB::commit();

        return response()->json($order, 200);
    }

    public function order(License $license, Order $order)
    {
        $license->load(['licenseType', 'applicant',
            'applicant.applicantData','property',
            'backgrounds', 'construction', 'owner',
            'validity', 'requirements', 'ads',
            'validations', 'observations',
            'order', 'order.duties']);

        $applicant = User::Where('id', $license->user_id)
            ->with('applicantData')
            ->get();

        $applicantData = ApplicantData::where('user_id',$license->user_id)->get();
        $order = $order->load('duties');

        $data = [
            'license'       => $license,
            'applicant'     => $applicant[0],
            'applicantData' => $applicantData[0],
            'order'         => self::setConceptDescription($license, $order),
        ];

        $pdf = PDF::loadView('orders.order', $data);
        Storage::put("public/solicitantes/{$license->user_id}/licencias/{$license->id}/OC-{$license->folio}.pdf",$pdf->output());
        return $pdf->stream();
    }

    public function storeOrder(User $user, License $license, Order $order)
    {
        $token = $user->api_op_token;
        $licType = $license->licenseType()->first();
        $owner   = $license->owner()->first();
        $duties  = $order->duties()->get();

        $data = [

            'nombre' => $owner->nombre_apellidos ?? $user->nombre,
            // 'descripcion' => $licType->nombre .' '. $licType->nota,
            'descripcion' => self::setConceptDescription($license, $order)['duties'][0]['descripcion'],
            'id' => $duties->map(function ($duty){
                return $duty->idCuenta;
            })->toArray(),
            'cantidad' => $duties->map(function ($duty){
                return $duty->cantidad;
            })->toArray(),
            'monto' => $duties->map(function ($duty){
                return $duty->monto;
            })->toArray(),
            'idexpress' => 2689
        ];

        $response = Http::withHeaders([
                'Authorization' => "Bearer {$token}",
            ])
            ->acceptJson()
            ->post('https://sefin.capitaldezacatecas.gob.mx/api/orden/store', $data);


        abort_if(!$response->successful(),500,'Error de inserción (API), intentelo más tarde.');
        return json_decode($response);
    }

    private function setConceptDescription(License $license, $order)
    {

        $licenseType = $this->checkLicenseType->checkLicenseType($license->license_type_id);


        switch ($licenseType){
            case 'construction':
                $months = self::calculateMonths($license);
                $order['duties']->map(function ($duty) use($license, $months){
                    if($duty->idCuenta == 155 || $duty->idCuenta == 208){
                        $duty->descripcion .= ' '.$license->construction->sup_total_amp_reg_const.' m2, '. $months. ' meses de duración; Ubicado en '.
                        $license->property->calle.' '.$license->property->no.', '.$license->property->colonia;
                    }
                });
                break;
            case 'compatibility':
                $order['duties']->map(function ($duty) use($license){
                    if($duty->idCuenta == 63){
                        $duty->descripcion .= ' Ubicado en '.
                        $license->property->calle.' '.$license->property->no.', '.$license->property->colonia;
                    }
                });
                break;
            case 'ad':
                $months = self::calculateMonths($license);
                $order['duties']->map(function ($duty) use($license, $months){
                    if($duty->idCuenta == 13){
                        $duty->descripcion .= ' '.$months. ' meses de duración; Ubicado en '.
                        $license->property->calle.' '.$license->property->no.', '.$license->property->colonia;
                    }
                });
                break;
            case 'vehicle_ad':
                $months = self::calculateMonths($license);
                $order['duties']->map(function ($duty) use($license, $months){
                    if($duty->idCuenta == 13){
                        $duty->descripcion .= ' '.$months. ' meses de duración.';
                    }
                });
                break;

            default:
                # code...
                break;
        }



        return $order;
    }

    /**
     * calculate the number of months for the license validity
     * @param License $license
     * @return int
     */
    public function calculateMonths(License $license)
    {
        $ts1 = strtotime($license->validity['fecha_autorizacion'] ?? Carbon::now());
        $ts2 = strtotime($license->validity['fecha_fin_vigencia'] ?? Carbon::now());

        $year1 = date('Y', $ts1);
        $year2 = date('Y', $ts2);

        $month1 = date('m', $ts1);
        $month2 = date('m', $ts2);

        return (($year2 - $year1) * 12) + ($month2 - $month1);
    }
}
