<?php

namespace App\Http\Controllers\LandUses;

use App\Http\Controllers\Controller;
use App\Http\Requests\LandUse\StoreLandUseDescriptionRequest;
use App\Http\Requests\LandUse\UpdateLandUseDescriptionRequest;
use App\Models\LandUse;
use App\Models\LandUseDescription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LandUsesDescriptionsController extends Controller
{
    public function store(StoreLandUseDescriptionRequest $request, LandUse $landUse)
    {
        $landUseDescData = $request->validated();

        DB::beginTransaction();

        $landUseDesc = new LandUseDescription($landUseDescData);
        try {
            $landUse->descriptions()->save($landUseDesc);
        } catch (\Throwable $th) {
            DB::rollBack();
            abort(500, 'No se ha guardado el uso de suelo, inténtalo más tarde. '. $th);
        }
        DB::commit();

        return response()->json($landUseDesc);
    }

    public function update(UpdateLandUseDescriptionRequest $request, LandUse $landUse, LandUseDescription $description)
    {
        $landUseDescData = $request->validated();

        DB::beginTransaction();

        try {
            $description->fill($landUseDescData);
            $description->save();
        } catch (\Throwable $th) {
            DB::rollBack();
            abort(500, 'No se ha guardado el uso de suelo, inténtalo más tarde. '. $th);
        }
        DB::commit();

        return response()->json($landUse->load('descriptions'));
    }
}
