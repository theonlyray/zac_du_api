<?php

namespace App\Http\Controllers\Licenses;

use App\Http\Controllers\Controller;
use App\Http\Requests\Licenses\StoreLicenseTypeRequest;
use App\Http\Requests\Licenses\UpdateLicenseTypeRequest;
use App\Http\Requests\Licenses\UpdateLicenseTypeRequirementRequest;
use App\Models\LicenseType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LicenseTypeController extends Controller
{

    public function index()
    {
        $this->authorize('index', LicenseType::class);

        $licenseType = LicenseType::getLicenseTypesByRoleUser(
            request()->user()
        );

        abort_if(empty($licenseType),204, 'No se encontraron tipos de licencia.');

        return response()->json($licenseType, 200);
    }

    public function show(LicenseType $licenseType)
    {
        $this->authorize('index', [LicenseType::class, $licenseType->department_id]);

        return response()->json($licenseType->load(['department', 'requirements']), 200);
    }

    public function store(StoreLicenseTypeRequest $request)
    {
        $licenseTypeData = $request->validated();

        $this->authorize('store', [LicenseType::class, $licenseTypeData['department_id']]);

        $licenseType = new LicenseType($licenseTypeData);

        DB::beginTransaction();

        try {
            $licenseType->save();

        } catch (\Throwable $th) {
            DB::rollBack();
            abort(500, 'No se ha guardado el tipo de trámite, inténtalo más tarde. '. $th);
        }

        DB::commit();

        return response()->json($licenseType, 200);
    }

    public function update(UpdateLicenseTypeRequest $request, LicenseType $licenseType)
    {
        $licenseTypeData = $request->validated();

        $this->authorize('update', [LicenseType::class, $licenseType->department_id]);

        $licenseType->fill($licenseTypeData);
        $licenseType->save();
        return response()->json($licenseType, 200);
    }
}
