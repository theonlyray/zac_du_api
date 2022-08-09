<?php

namespace App\Http\Controllers\Orders;

use App\Http\Controllers\Controller;
use App\Http\Requests\Order\DestroyOrderRequest;
use App\Http\Requests\Order\StoreOrderRequest;
use App\Http\Requests\Order\UpdateOrderPaymentRequest;
use App\Http\Requests\Order\UpdateOrderRequest;
use App\Models\ApplicantData;
use App\Models\Duty;
use App\Models\File;
use App\Models\License;
use App\Models\LicenseType;
use App\Models\Order;
use App\Models\User;
use App\Services\StorageService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class OrderController extends Controller
{
    protected $totalGral;
    protected $storage;

    public function __construct(StorageService $storage)
    {
        $this->storage = $storage;
        $this->totalGral = 0;
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

        foreach ($request->derechos as $key => $value) {
            $duty = Duty::firstWhere('id', $value['id']);
            $this->totalGral += $duty['precio'] * $value['cantidad'];
            $duties[$value['id']] = [
                "precio"        => $duty['precio'],
                "cantidad"      => $value['cantidad'],
                "total"         => $duty['precio'] * $value['cantidad'],
            ];
        }
        $order = [
            'total' => $this->totalGral,
            'creator_id' => $user->id,
            'license_id' => $license->id,
        ];
        $order = new Order($order);

        DB::beginTransaction();

        try {
            $order->save();
            $order->duties()->sync($duties);
        } catch (\Throwable $th) {
            DB::rollBack();
            abort(500, 'No se ha podido generar la orden, intentelo más tarde. '.$th);
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
                foreach ($request->derechos as $key => $value) {
                    $duty = Duty::firstWhere('id', $value['id']);
                    $this->totalGral += $duty['precio'] * $value['cantidad'];
                    $duties[$value['id']] = [
                        "precio"        => $duty['precio'],
                        "cantidad"      => $value['cantidad'],
                        "total"         => $duty['precio'] * $value['cantidad'],
                    ];
                }

                $order->total       = $this->totalGral;
                $order->duties()->sync($duties);
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

    public function validating(Request $request, License $license, Order $order)
    {
        $department = LicenseType::find($license->license_type_id);

        $this->authorize('validate', [Order::class, $department->department_id, null, $order]);

        DB::beginTransaction();

        try {
            $order->validada = true;
            $order->save();

            $license->estatus = 11;
            $license->save();
        } catch (\Throwable $th) {
            DB::rollBack();
            abort(500, 'No se ha eliminado la orden inténtalo más tarde. '. $th->getMessage());
        }

        DB::commit();

        return response()->json($order, 200);
    }

    public function order(License $license, Order $order)
    {
        $license->load(['licenseType', 'applicant',
            'applicant.applicantData','property',
            'backgrounds', 'construction', 'owner',
            'validity', 'requirements', 'ad',
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
            'order'        => $order,
        ];

        // logger($priorLicenses);
        $pdf = PDF::loadView('orders.order', $data);
        Storage::put("public/solicitantes/{$license->user_id}/licencias/{$license->id}/OC-{$license->folio}.pdf",$pdf->output());
        return $pdf->stream();
    }
}
