<?php

namespace App\Http\Controllers\Departments;

use App\Http\Controllers\Controller;
use App\Http\Requests\Department\DestroyDepartmentRequest;
use App\Http\Requests\Department\StoreDepartmentRequest;
use App\Http\Requests\Department\UpdateDepartmentRequest;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DepartmentController extends Controller
{
    public function index()
    {
        $this->authorize('index', Department::class);

        $departments = Department::all();

        abort_if($departments->isEmpty(), 204, 'No se encontraron departamentos.');

        return response()->json($departments, 200);
    }

    public function show(Department $department)
    {
        $this->authorize('show', $department);

        $department = $department->load('users');
        $department->users = $department->users->map(function($user){
            $user->getRoleNames();
            return $user;
        });

        return response()->json($department, 200);
    }

    public function store(StoreDepartmentRequest $request)
    {
        $this->authorize('store', Department::class);

        $departmentData = $request->validated();

        $department = new Department($departmentData);

        DB::beginTransaction();

        try {
            $department->save();
        } catch (\Throwable $th) {
            DB::rollBack();
            abort(500, 'No se ha guardado el departamento, inténtalo más tarde. '. $th);
        }

        DB::commit();

        return response()->json($department, 200);
    }

    public function update(UpdateDepartmentRequest $request, Department $department)
    {
        $this->authorize('update', $department);

        $department->fill($request->validated());
        $department->save();
        return response()->json($department, 200);
    }
}
