<?php

namespace App\Http\Controllers\Units;

use App\Http\Controllers\Controller;
use App\Http\Requests\Unit\StoreUnitRequest;
use App\Http\Requests\Unit\UpdateUnitRequest;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UnitController extends Controller
{
    public function index()
    {
        $this->authorize('index', Unit::class);

        $user = request()->user();
        $unit = Unit::getUnitsByRole($user);

        if (!empty($unit)) return response()->json($unit, 200);

        abort(204, 'No se encontraron Unidades.');
    }

    public function show(Unit $Unit)
    {
        $this->authorize('index', [Unit::class, $Unit->department_id]);

        return response()->json($Unit->load(['department', 'requirements']), 200);
    }

    public function store(StoreUnitRequest $request)
    {
        $UnitData = $request->validated();

        $this->authorize('store', [Unit::class, $UnitData['department_id']]);

        $Unit = new Unit($UnitData);

        DB::beginTransaction();

        try {
            $Unit->save();

        } catch (\Throwable $th) {
            DB::rollBack();
            abort(500, 'No se ha guardado el tipo de trámite, inténtalo más tarde. '. $th);
        }

        DB::commit();

        return response()->json($Unit, 200);
    }

    public function update(UpdateUnitRequest $request, Unit $Unit)
    {
        $UnitData = $request->validated();

        $this->authorize('update', [Unit::class, $Unit->department_id]);

        $Unit->fill($UnitData);
        $Unit->save();
        return response()->json($Unit, 200);
    }
}
