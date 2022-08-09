<?php

namespace App\Http\Controllers\Duties;

use App\Http\Controllers\Controller;
use App\Http\Requests\Duty\DestroyDutyRequest;
use App\Http\Requests\Duty\StoreDutyRequest;
use App\Http\Requests\Duty\UpdateDutyRequest;
use App\Models\Duty;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DutyController extends Controller
{
    public function index()
    {
        $department = request()->query('department');

        $this->authorize('index', [Duty::class, $department]);

        $user = request()->user();

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
