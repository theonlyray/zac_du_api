<?php

namespace App\Http\Controllers\Licenses;

use App\Events\RequestValidated;
use App\Http\Controllers\Controller;
use App\Http\Requests\Licenses\StoreLicenseObservationRequest;
use App\Http\Requests\Licenses\UpdateLicenseRequest;
use App\Http\Requests\Licenses\StoreLicenseRequest;
use App\Http\Requests\Licenses\UpdateLicenseMapRequest;
use App\Http\Requests\Licenses\UpdateLicenseRequirementsRequest;
use App\Models\AdDescription;
use App\Models\CompatibilityCertificate;
use App\Models\ConstructionBackground;
use App\Models\ConstructionDescription;
use App\Models\ConstructionLocation;
use App\Models\ConstructionOwner;
use App\Models\License;
use App\Models\LicenseObservation;
use App\Models\LicenseRequirement;
use App\Models\LicenseType;
use App\Models\LicenseTypes;
use App\Models\LicenseValidation;
use App\Models\LicenseValidity;
use App\Models\Property;
use App\Models\Requirement;
use App\Models\SFD;
use App\Services\StorageService;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

use function PHPUnit\Framework\isNull;
use function Symfony\Component\String\b;

class LicenseController extends Controller
{
    protected $storage;

    public function __construct(StorageService $storage)
    {
        $this->storage = $storage;
    }

    public function counter()
    {
        $this->authorize('index', License::class);

        $user = request()->user();

        $count  = License::counter($user);

        if($count) return response()->json($count, 200);
    }

    public function index()
    {
        $this->authorize('index', License::class);

        $user   = request()->user();
        $status = request()->query('estatus');

        $allowsParams = collect(['Solicitudes', 'Proceso', 'Autorizadas', 'Canceladas', 'Rechazadas']);
        $isAllowed = $allowsParams->first(function ($item) use ($status){
            return $item == $status;
        });

        if ($isAllowed === null) {
            abort(400, 'Petición no aceptada, parametros incorrectos o faltantes. '. $status .  ' ');
        }else{
            $licenses = License::getLicencesList($user, $status);

            if ($licenses->isNotEmpty()) return response()->json($licenses, 200);

            abort(204, 'No se encontraron licencias.');
        }
    }


    public function show(License $license)
    {
        $this->authorize('show', [License::class, $license]);

        return response()->json($license->load([
            'licenseType', 'applicant', 'property',
            'backgrounds', 'construction', 'owner',
            'validity', 'requirements', 'ad',
            'validations', 'observations'
        ]), 200);
    }

    public function store(StoreLicenseRequest $request)
    {
        $this->authorize('store', License::class, $request->license_type_id);

        $user = $request->user();

        $licenseData    = $request->validated();
        $license        = new License($licenseData);

        DB::beginTransaction();
        try {
            $license->save();

            if ($request->license_type_id >= 1 && $request->license_type_id <= 3) { //? construcción menos y mayor a 45 m2, especial
               //?backgrounds
                if ($request->backgrounds[0] <> null) {
                    $backgrounds = collect($request->backgrounds)->map(function ($background) use($license){
                        $background['current_license_id'] = $license->id;
                        return new ConstructionBackground($background);
                    });
                    $license->backgrounds()->saveMany($backgrounds);
                }

                //?construction description
                $description =  new ConstructionDescription($request->construction);
                $license->construction()->save($description);


                //?propety description
                $property = new Property($request->property);
                $uploadedFile = $this->storage->uploadBase64File(
                    $request->property['mapa'],
                    "public/solicitantes/{$license->user_id}/licencias/{$license->id}",
                    'map'
                );

                $property->mapa_ubicacion    = $uploadedFile['path'];
                $property->mapa_url          = $uploadedFile['url'];

                $license->property()->save($property);

                // if($request->user()->hasRole('dro')){
                if(!$request->owner['ownerFlag']){
                    $ownerData = $request->owner;
                }else {
                    $applicantData = $user->applicantData;
                    $ownerData['nombre_apellidos'] = $user->nombre;
                    $ownerData['rfc'] = $applicantData->rfc;
                    $ownerData['domicilio'] = "{$applicantData->calle} {$applicantData->no} {$applicantData->colonia} {$applicantData->cp}";
                    $ownerData['ocupacion'] = $applicantData->ocupacion;
                    $ownerData['telefono'] = $applicantData->celular;
                }
                $owner =  new ConstructionOwner($ownerData);
                $license->owner()->save($owner);
            }

            if ($request->license_type_id == 16) {//? constancia compatibilidad
                $compatibility = new CompatibilityCertificate($request->compatibilidad);
                $license->compatibilityCertificate()->save($compatibility);
            }

            if ($request->license_type_id >= 17 && $request->license_type_id <= 20) {//? anuncios
                $ad = new AdDescription($request->anuncio);
                $license->ad()->save($ad);
            }

            if ($request->license_type_id >= 22) {//? sfd
                $sfd = new SFD($request->sfd);
                $license->sfd()->save($sfd);
            }

            $requirements = Requirement::where('license_type_id',$licenseData['license_type_id'])->get();
            $requirementsData = collect($requirements)->map(function ($requiment) use ($license) {
                $data['requirement_id'] = $requiment['id'];
                $data['license_id'] = $license->id;
                return new LicenseRequirement($data);
            });
            $license->requirements()->saveMany($requirementsData);
        } catch (\Throwable $th) {
            DB::rollBack();
            $this->storage
                ->deleteDirectory("public/solicitantes/{$user->id}/licencias/{$license->id}");
            abort(500, 'No se ha podido generar la licencia, intentelo más tarde '. $th);
        }
        DB::commit();

        return response()->json($license, 200);
        // return response()->json($licenseData, 200);
    }

    public function update(UpdateLicenseRequest $request, License $license)
    {
        $this->authorize('update', [License::class, $license]);

        DB::beginTransaction();

        $responseEvent = true;
        try {
            // $license['estatus'] = $request->estatus;

            // if ($request->estatus == 4 || $request->estatus == 5 || $request->estatus == 7 || $request->estatus == 9) {
            //     $responseEvent = event(new RequestValidated(request()->user(), $license));
            // }

            // if ($responseEvent == true || $request->estatus == 1) $license->save();
            // else abort(403, $responseEvent);

            $property = Property::firstWhere('license_id', $license->id);
            $property->fill($request->property);
            $property->save();

            if ($request->license_type_id <= 2) { //? construcción menos y mayor a 45 m2
                $description = ConstructionDescription::firstWhere('license_id', $license->id);
                $description->fill($request->construction);

                $license->construction()->save($description);

                $owner = ConstructionOwner::firstWhere('license_id', $license->id);
                $owner->fill($request->owner);
                $license->owner()->save($owner);

                if (!empty($request->backgrounds)) {
                    $backgrounds = collect($request->backgrounds)->map(function ($item) use($license){
                        if (isset($item['id'])) {
                            $background = ConstructionBackground::firstWhere('id', $item['id']);
                            $background->fill($item);
                        }else {
                            $background = new ConstructionBackground($item);
                            $background['current_license_id'] = $license->id;
                        }
                        return $background;
                    });
                    $license->backgrounds()->saveMany($backgrounds);
                }
            }

            if (!is_null($request->validity['fecha_autorizacion']) && !is_null($request->validity['fecha_fin_vigencia'])) {
                $validity = LicenseValidity::firstWhere('license_id', $license->id);
                $diff = date_diff(date_create($request->validity['fecha_autorizacion']), date_create($request->validity['fecha_fin_vigencia']));

                $validityData = [
                    'dias_total' => $diff->format("%a"),
                    'fecha_autorizacion' => $request->validity['fecha_autorizacion'],
                    'fecha_fin_vigencia' => $request->validity['fecha_fin_vigencia'],
                ];
                if (is_null($validity)) $validity = new LicenseValidity($validityData);
                else $validity->fill($validityData);

                $license->validity()->save($validity);
            }


        } catch (\Throwable $th) {
            DB::rollBack();
            abort(500, 'No se ha podido actualizar la licencia, intentelo más tarde '. $th->getMessage());
        }
        DB::commit();

        return response()->json($license->load([
            'licenseType', 'applicant', 'property',
            'backgrounds', 'construction', 'owner',
            'validity', 'requirements', 'validations',
            'observations'
        ]), 200);
    }

    public function updateMap(Request $request, License $license)
    {
        $this->authorize('update', $license);

        $user = $request->user();
        $this->validate(
            $request,
            ['mapa' => 'required|filled'],
            ['filled' => 'El campo :attribute no debe estar vacío.'],
        );

        try {
            $this->storage->deleteFiles([$license->load('property')->mapa_ubicacion]);

            //?propety description
            $uploadedFile = $this->storage->uploadBase64File(
                $request->property['mapa'],
                "public/solicitantes/{$license->user_id}/licencias/{$license->id}",
                'map'
            );

            $newData['mapa_ubicacion']    = $uploadedFile['path'];
            $newData['mapa_url']          = $uploadedFile['url'];

            $property = Property::firstWhere('license_id', $license->id);
            $property->fill($newData);
            $license->property()->save($property);


        } catch (\Throwable $th) {
            abort(400, $th);
            // abort(500, 'No se ha podido guardar el mapa, intentelo más tarde');
        }
        return response()->json($license->load([
            'licenseType', 'applicant', 'property',
            'backgrounds', 'construction', 'owner',
            'validity', 'requirements',
        ]), 200);
    }


    public function background(License $license, ConstructionBackground $background)
    {

        $this->authorize('update', [License::class, $license]);

        DB::beginTransaction();
        try {
            ConstructionBackground::where('id', $background->id)->delete();
        } catch (\Throwable $th) {
            DB::rollBack();
            abort(500, 'No se ha podido eliminar el antecedente, intentelo más tarde '. $th);
        }

        DB::commit();

        return response()->json($license->load([
            'licenseType', 'applicant', 'property',
            'backgrounds', 'construction', 'owner',
            'validity', 'requirements', 'validations',
            'observations'
        ]), 200);
    }

    public function updateRequirement(
        UpdateLicenseRequirementsRequest $request,
        License $license,
        LicenseRequirement $requirements)
    {
        $this->authorize('requirements', [License::class, $license]);

        try {
            //?if there is an old file, delete it
            $requirements->archivo_ubicacion != null && $request->archivo != null ?
                $this->storage->deleteFiles([$requirements->archivo_ubicacion]) : null;

            if ($request->archivo != null) { //?if there is a new file, save it
                $uploadedFile = $this->storage->saveDocumentBlueprint(
                    $request->archivo,
                    "public/solicitantes/{$license->user_id}/licencias/{$license->id}/requisitos",
                    $request->nombre
                );

                $requirements->archivo_ubicacion    = $uploadedFile['path'];
                $requirements->archivo_url          = $uploadedFile['url'];
                $requirements->archivo_nombre       = $request->nombre;
            }

            $requirements->estatus              = $request->estatus;
            $requirements->comentario           = $request->comentario;

            if ($request->estatus == 4) $requirements->fecha_autorizacion = Carbon::now();

            $requirements->save();

        } catch (\Throwable $th) {
            abort(500, 'No se ha podido actualizar el requisito, intentelo más tarde.'. $th);
        }
        return response()->json($license->load('licenseType', 'applicant', 'property',
        'backgrounds', 'construction', 'owner',
        'validity', 'requirements', 'validations', 'observations'), 200);
    }

    public function observations(StoreLicenseObservationRequest $request, License $license)
    {
        $this->authorize('observations', [License::class, $request->contrasenia]);

        DB::beginTransaction();

        try {
            $observation = new LicenseObservation([
                'observaciones' => $request->observacion,
                'user_id'       => $request->user()->id,
            ]);
            $license->observations()->save($observation);

            $license->estatus = $request->estatus;
            $license->save();

        } catch (\Throwable $th) {
            DB::rollBack();
            abort(500, 'No se ha podido generar la observación, intentelo más tarde.'. $th);
        }

        DB::commit();

        return response()->json($license->load('licenseType', 'applicant', 'property',
            'backgrounds', 'construction', 'owner',
            'validity', 'requirements', 'validations',
            'observations'), 200);
    }

    public function validations(Request $request, License $license)
    {
        $this->authorize('validations', [License::class, $request->estatus]);

        $user = $request->user();

        DB::beginTransaction();

        $license['estatus'] = $request->estatus;
        if ($request->estatus == 4 || $request->estatus == 5 || $request->estatus == 7 || $request->estatus == 9) {
            try {
                $validition = new LicenseValidation(['user_id' => $user->id, 'descripcion' => $license->estatus]);
                $license->validations()->save($validition);

                $observations = LicenseObservation::where('created_at', '<=', Carbon::now())->get(); //get observations befo current validation

                $observations = $observations->map(function ($observation){
                    $observation->solventada = true; //?if theres a new validation old observations must be solved
                        return $observation->save();
                });
            } catch (\Throwable $th) {
                //throw $th;
                logger($th);
                DB::rollBack();
                return 'Error al generar validación '. $th->getMessage();
            }
        }
        $license->save();
        DB::commit();

        return response()->json($license->load('licenseType', 'applicant', 'property',
            'backgrounds', 'construction', 'owner',
            'validity', 'requirements', 'validations',
            'observations'), 200);
    }
}
