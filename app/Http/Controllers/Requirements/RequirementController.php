<?php

namespace App\Http\Controllers\Requirements;

use App\Http\Controllers\Controller;
use App\Http\Requests\Requirement\StoreRequirementRequest;
use App\Http\Requests\Requirement\UpdateRequirementRequest;
use App\Models\LicenseType;
use App\Models\Requirement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RequirementController extends Controller
{
    public function index(Request $request)
    {
        $licenseType = LicenseType::find($request->query('license_type'));

        $this->authorize('index', [Requirement::class, $licenseType->department_id]);

        $requirements = Requirement::getRequirementsByLicenseTypeAndUserRole(
            $licenseType->id,
            $request->user()
        );

        if (!empty($requirements)) return response()->json($requirements, 200);

        abort(204, 'No se encontraron requisitos.');
    }

    public function show(Requirement $requirement)
    {
        $licenseType = LicenseType::find($requirement->license_type_id);

        $this->authorize('show', [Requirement::class, $licenseType->department_id]);

        return response()->json($requirement->load('licenseType'), 200);
    }

    public function store(StoreRequirementRequest $request)
    {
        $requirementData = $request->validated();
        $licenseType = LicenseType::find($requirementData['license_type_id']);

        $this->authorize('store', [Requirement::class, $licenseType->department_id]);

        $requirement = new Requirement($requirementData);

        DB::beginTransaction();

        try {
            $requirement->save();
        } catch (\Throwable $th) {
            DB::rollBack();
            abort(500, 'No se ha guardado el requisito, inténtalo más tarde. '. $th);
        }

        DB::commit();

        return response()->json($requirement, 200);
    }

    public function update(UpdateRequirementRequest $request, Requirement $requirement)
    {
        $requirementData = $request->validated();
        $licenseType = LicenseType::find($requirementData['license_type_id']);

        $this->authorize('update', [Requirement::class, $licenseType->department_id]);

        $requirement->fill($requirementData);
        $requirement->save();
        return response()->json($requirement, 200);
    }
}
