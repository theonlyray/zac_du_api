<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Departments\DepartmentController;
use App\Http\Controllers\Files\FileController;
use App\Http\Controllers\Duties\DutyController;
use App\Http\Controllers\LandUses\LandUsesController;
use App\Http\Controllers\LandUses\LandUsesDescriptionsController;
use App\Http\Controllers\Licenses\LicenseController;
use App\Http\Controllers\Licenses\LicenseTypeController;
use App\Http\Controllers\Orders\OrderController;
use App\Http\Controllers\Payments\PaymentController;
use App\Http\Controllers\Pdfs\PdfController;
use App\Http\Controllers\Profile\ProfileController;
use App\Http\Controllers\Properties\PropertyController;
use App\Http\Controllers\Requirements\RequirementController;
use App\Http\Controllers\Specialties\SpecialtyController;
use App\Http\Controllers\Units\UnitController;
use App\Http\Controllers\Users\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('autenticacion')->group(function () {
    Route::get('/colegios', [AuthController::class, 'getColleges']);
    Route::get('/departamentos', [AuthController::class, 'getDepartments']);
    // Route::get('/usuarios', [AuthController::class, 'getUsers']);
    Route::post('/registro', [AuthController::class, 'signUp']);
    Route::get('/login', [AuthController::class, 'logInToken'])
        ->middleware('auth:sanctum');
    Route::post('/login', [AuthController::class, 'logIn']);
    Route::get('/docs', [AuthController::class, 'docs']);
    Route::post('/recuperacion', [AuthController::class, 'resetPassword']);
    Route::get('/license', [AuthController::class, 'license']);
});


/**
 * Payments routes bank integration
 */
Route::post('/pagos', [PaymentController::class, 'store']);
Route::get('/pagos', [PaymentController::class, 'index']);
Route::patch('/pagos', [PaymentController::class, 'syncOrders']);

/**
 * Payments routes
 */
// Route::apiResource('/pagos', PaymentController::class)
//     ->only(['index', 'store']);

Route::middleware('auth:sanctum')->group(function () {

    Route::prefix('autenticacion')->group(function () {
        Route::get('/logout', [AuthController::class, 'logOut']);
        Route::post('/logOutToken', [AuthController::class, 'logOutToken']);
        Route::get('/roles', [AuthController::class, 'getRoles']);
        Route::patch('/roles/{role}', [AuthController::class, 'updateRole']);
        Route::get('/permisos', [AuthController::class, 'getPermissions']);
        // Route::get('/actividades', [AuthController::class, 'getActivities']);
    });

    /**
     * User profile routes
     */
    Route::prefix('perfil')->group(function () {
        Route::get('/', [ProfileController::class, 'index']);
        Route::patch('/', [ProfileController::class, 'update']);
        Route::patch('/especialidades', [ProfileController::class, 'specialties']);
    });

    /**
     * Deparments routes
     */
    Route::apiResource('departamentos', DepartmentController::class)
    ->parameters(['departamentos' => 'department']);

    /**
     * Units routes
     */
    Route::apiResource('unidades', UnitController::class)
    ->parameters(['unidades' => 'unit']);

    /**
     * Licenses types routes
     */
    Route::apiResource('tipos_licencia', LicenseTypeController::class)
        ->parameters(['tipos_licencia' => 'licenseType']);

    /**
     * Duties routes
     */
    Route::apiResource('derechos', DutyController::class)
    ->parameters(['derechos' => 'duty']);

    /**
     * Requirements routes
     */
    Route::apiResource('requisitos', RequirementController::class)
        ->parameters(['requisitos' => 'requirement']);

    /**
     * Files routes
     */
    Route::apiResource('archivos', FileController::class)
        ->parameters(['archivos' => 'file']);

    /**
     * Users routes
     */
    Route::apiResource('usuarios', UserController::class)
        ->parameters(['usuarios' => 'user']);
    Route::prefix('usuarios')->group(function () {
        Route::patch('/{user}/permisos', [UserController::class, 'permissions']);
    });


    /**
     * Licenses routes
     */
    Route::get('/contador', [LicenseController::class, 'counter']);
    Route::get('/folios', [LicenseController::class, 'folios']);
    Route::apiResource('licencias', LicenseController::class)
        ->parameters([
            'licencias' => 'license',
            // 'antecendente' => 'background'
        ]);

    Route::prefix('licencias')->group(function () {
        Route::post('/pagos', [PaymentController::class, 'syncOrders']);
        Route::post('/reporte', [LicenseController::class, 'export']);
        Route::post('/{license}/generate-qr', [LicenseController::class, 'generateQR']);
        Route::patch('/{license}/requisitos/{requirements}', [LicenseController::class, 'updateRequirement']);
        Route::patch('/{license}/mapa', [LicenseController::class, 'updateMap']);
        Route::delete('/{license}/antecendente/{background}', [LicenseController::class, 'background']);
        Route::delete('/{license}/actividad/{sfd}', [LicenseController::class, 'sfd']);
        Route::delete('/{license}/lote/{lot}', [LicenseController::class, 'lot']);
        Route::delete('/{license}/anuncio/{ad}', [LicenseController::class, 'ad']);
        Route::patch('/{license}/validaciones', [LicenseController::class, 'validations']);
        Route::patch('/{license}/observaciones', [LicenseController::class, 'observations']);
        Route::post('/{license}/sublicencia', [LicenseController::class, 'sublicense']);
        Route::post('/{license}/refrendo', [LicenseController::class, 'countersign']);
        Route::get('/{license}/licencia', [PdfController::class, 'license']);
        Route::get('/{license}/preview', [PdfController::class, 'preview']);
        Route::get('/{license}/solicitud', [PdfController::class, 'request']);
    });

    /**
     * Order routes
     */

    Route::prefix('licencias/{license}/orden/{order}')->group(function () {
        Route::patch('/pago', [OrderController::class, 'updatePayment']);
        Route::patch('/validar', [OrderController::class, 'validating']);
        Route::get('/pdf', [OrderController::class, 'order']);
    });

    Route::apiResource('licencias.orden', OrderController::class)
    ->parameters([
        'licencias' => 'license',
        'orden'     => 'order',
    ]);

    /**
     * Uses routes
     */
    Route::apiResource('usos', LandUsesController::class)
        ->parameters(['usos' => 'landUse']);
});
