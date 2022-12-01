<?php

namespace App\Http\Controllers\LandUses;

use App\Http\Controllers\Controller;
use App\Http\Requests\LandUse\StoreLandUseRequest;
use App\Http\Requests\LandUse\UpdateLandUseRequest;
use App\Models\LandUse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LandUsesController extends Controller
{
    public function index()
    {
        return response()->json(LandUse::all());
    }

    public function show(LandUse $landUse)
    {
        return response()->json($landUse->load('descriptions'));
    }

    public function store(StoreLandUseRequest $request)
    {
        $landUseData = $request->validated();

        DB::beginTransaction();

        $landUse = new LandUse($landUseData);
        try {
            $landUse->save();
        } catch (\Throwable $th) {
            DB::rollBack();
            abort(500, 'No se ha guardado el uso de suelo, inténtalo más tarde. '. $th);
        }

        DB::commit();

        return response()->json($landUse->load('descriptions'));
    }

    public function update(UpdateLandUseRequest $request, LandUse $landUse)
    {
        $landUseData = $request->validated();

        DB::beginTransaction();

        try {
            $landUse->fill($landUseData);
            $landUse->save();
        } catch (\Throwable $th) {
            DB::rollBack();
            abort(500, 'No se ha guardado el uso de suelo, inténtalo más tarde. '. $th);
        }

        DB::commit();

        return response()->json($landUse->load('descriptions'));
    }
}
