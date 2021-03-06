<?php

namespace App\Http\Controllers\Orders;

use App\Http\Controllers\Controller;
use App\Http\Requests\Order\DestroyOrderRequest;
use App\Http\Requests\Order\StoreOrderRequest;
use App\Http\Requests\Order\UpdateOrderPaymentRequest;
use App\Http\Requests\Order\UpdateOrderRequest;
use App\Models\Duty;
use App\Models\File;
use App\Models\License;
use App\Models\LicenseType;
use App\Models\Order;
use App\Services\StorageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
            abort(500, 'No se ha podido generar la orden, intentelo m??s tarde. '.$th);
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
            $order->validada    = $request->validada ?? $order->validada;
            $order->pagada      = $request->pagada ?? $order->pagada;
            $order->save();

        } catch (\Throwable $th) {
            DB::rollBack();
            abort(500, 'No se ha actualziar la orden de pago int??ntalo m??s tarde. '. $th);
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
            abort(500, 'No se ha podido cargar el comprobante, intentelo m??s tarde.'. $th);
        }
        return response()->json($license->load(['order.duties','order.file']), 200);
    }

    public function destroy(DestroyOrderRequest $request, License $license, Order $order)
    {
        $department = LicenseType::find($license->license_type_id);

        $this->authorize('destroy', [Order::class, $department->department_id, null, $order, $request->contrasenia]);

        DB::beginTransaction();

        try {
            // $order->delete();
        } catch (\Throwable $th) {
            DB::rollBack();
            abort(500, 'No se ha eliminado la orden int??ntalo m??s tarde. '. $th);
        }

        DB::commit();

        return response()->json($order, 200);
    }
}
