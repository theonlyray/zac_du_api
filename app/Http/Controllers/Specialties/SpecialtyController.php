<?php

namespace App\Http\Controllers\Specialties;

use App\Http\Controllers\Controller;
use App\Http\Requests\Specialty\StoreSpecialtyRequest;
use App\Http\Requests\Specialty\UpdateSpecialtyRequest;
use App\Models\Specialty;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SpecialtyController extends Controller
{
    public function index(Request $request)
    {
        $college = $request->query('college');

        $this->authorize('index', Specialty::class);

        $specialties = Specialty::where('college_id', $college)->get();

        if ($specialties->isNotEmpty()) return response()->json($specialties, 200);

        abort(204, 'No se encontraron especialidades.');
    }

    public function show(Specialty $specialty)
    {
        $this->authorize('show', Specialty::class);

        return response()->json($specialty->load('users', 'college'), 200);
    }

    public function store(StoreSpecialtyRequest $request)
    {
        $specialtyData = $request->validated();

        $this->authorize('store', [Specialty::class, $specialtyData]);

        $specialty = new Specialty($specialtyData);

        DB::beginTransaction();

        try {
            $specialty->save();
        } catch (\Throwable $th) {
            DB::rollBack();
            abort(500, 'No se ha guardado la especialidad, inténtalo más tarde. '. $th);
        }

        DB::commit();

        return response()->json($specialty, 201);
    }

    public function update(UpdateSpecialtyRequest $request, Specialty $specialty)
    {
        $this->authorize('update', [Specialty::class, $specialty]);

        $specialty->nombre = $request->nombre;
        $specialty->save();
        return response()->json($specialty, 200);
    }
}
