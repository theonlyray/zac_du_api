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

    public function folios()
    {
        $this->authorize('index', License::class);

        // todo update by role
        $licenses = License::where('estatus', 14)->get(['id','folio']);

        abort_if($licenses->isEmpty(), 204, 'No se encontraron licencias.');

        return response()->json($licenses, 200);
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

        abort_if($isAllowed === null, 400, 'Petición no aceptada, parametros incorrectos o faltantes. '. $status .  ' ');

        $licenses = License::getLicencesList($user, $status);

        abort_if($licenses->isEmpty(), 204, 'No se encontraron licencias.');

        return response()->json($licenses, 200);
    }

    public function show(License $license)
    {
        $this->authorize('show', [License::class, $license]);

        return response()->json($license->load([
            'licenseType', 'applicant', 'property',
            'backgrounds', 'construction', 'owner',
            'validity', 'requirements', 'ad',
            'validations', 'observations',
            'order', 'order.duties', 'applicant.applicantData',
            'compatibilityCertificate', 'SFD'
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

            if ($request->license_type_id != 20 && $request->license_type_id != 13){//? vehicle ad || selfconstruction
                //?propety description
                self::saveProperty($request, $license);
            }

            //? numbers in db, id license type
            if ($request->license_type_id >= 1 && $request->license_type_id <= 6 ||
                ($request->license_type_id >= 8 && $request->license_type_id <= 11) ||
                ($request->license_type_id == 15) ||
                ($request->license_type_id >= 25 && $request->license_type_id <= 28)
            ) { //? permisos de construccion
               //?backgrounds
                if ($request->backgrounds[0] <> null) {
                    self::saveBackgrounds($request, $license);
                }

                //?construction description
                self::saveConstructionDescriptions($request, $license);

                self::saveConstructionOwner($request, $license, $user);
            }

            if ($request->license_type_id == 7 || $request->license_type_id == 12 ||
                $request->license_type_id == 22 ||$request->license_type_id == 24) {
                //?no oficial | romper pavimento | constancia de servicios
                self::saveConstructionOwner($request, $license, $user);
            }

            if ($request->license_type_id == 13) {
                //?constancia autoconstruccion
                self::saveBackgrounds($request, $license);
            }

            if ($request->license_type_id == 16) {//? constancia compatibilidad
                self::saveCompatibilityCertificate($request, $license);
            }

            if ($request->license_type_id >= 17 && $request->license_type_id <= 20) {//? anuncios
                self::saveAdDescription($request, $license);
            }

            if ($request->license_type_id == 22) {//? sfd
                self::saveSFD($request, $license);
            }

            self::saveRequirements($licenseData, $license);
        } catch (\Throwable $th) {
            DB::rollBack();
            $this->storage
                ->deleteDirectory("public/solicitantes/{$user->id}/licencias/{$license->id}");
            abort(500, 'No se ha podido generar la licencia, intentelo más tarde '. $th->getMessage());
        }
        DB::commit();

        return response()->json($license, 200);
        // return response()->json($licenseData, 200);
    }

    public function update(UpdateLicenseRequest $request, License $license)
    {
        $this->authorize('update', [License::class, $license]);

        DB::beginTransaction();

        try {

            if ($request->license_type_id != 20){//? vehicle ad
                $property = Property::firstWhere('license_id', $license->id);
                $property->fill($request->property);
                $property->save();
            }

            //? numbers in db, id license type
            if ($request->license_type_id >= 1 && $request->license_type_id <= 6 ||
                ($request->license_type_id >= 8 && $request->license_type_id <= 11) ||
                ($request->license_type_id == 15) ||
                ($request->license_type_id >= 25 && $request->license_type_id <= 28)
            ) { //? permisos de construccion
                $description = ConstructionDescription::firstWhere('license_id', $license->id);
                $description->fill($request->construction);

                $license->construction()->save($description);

                $owner = ConstructionOwner::firstWhere('license_id', $license->id);
                $owner->fill($request->owner);
                $license->owner()->save($owner);

                if (!empty($request->backgrounds)) {
                    self::updateBackgrounds($request, $license);
                }
            }

            if ($request->license_type_id == 7 || $request->license_type_id == 12 ||
                $request->license_type_id == 22 || $request->license_type_id == 24) {
                //?no oficial | romper pavimento
                $owner = ConstructionOwner::firstWhere('license_id', $license->id);
                $owner->fill($request->owner);
                $license->owner()->save($owner);
            }

            if ($request->license_type_id == 13) {
                //?constancia autoconstruccion
                self::updateBackgrounds($request, $license);
            }

            if ($request->license_type_id == 16) {//? compatibilityCertificate
                $compatibilityCertificate = CompatibilityCertificate::firstWhere('license_id', $license->id);
                $compatibilityCertificate->fill($request->compatibility_certificate);
                $license->compatibilityCertificate()->save($compatibilityCertificate);
            }

            if ($request->license_type_id >= 17 && $request->license_type_id <= 20) {//? anuncios
                $ad = AdDescription::firstWhere('license_id', $license->id);
                $ad->fill($request->ad);
                $license->ad()->save($ad);
            }

            if ($request->license_type_id == 22) {//? anuncios
                $sfd = SFD::firstWhere('license_id', $license->id);
                $sfd->fill($request->s_f_d);
                $license->SFD()->save($sfd);
            }

            if (!is_null($request->validity)) {
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
            'observations', 'ad'
        ]), 200);
    }

    public function updateMap(UpdateLicenseMapRequest $request, License $license)
    {
        $this->authorize('update', [License::class, $license]);

        $user = $request->user();
        // $this->validate(
        //     $request,
        //     ['mapa' => 'required|filled'],
        //     ['filled' => 'El campo :attribute no debe estar vacío.'],
        // );

        try {
            $this->storage->deleteFiles([$license->load('property')->mapa_ubicacion]);

            //?propety description
            $uploadedFile = $this->storage->uploadBase64File(
                $request->mapa,
                "public/solicitantes/{$license->user_id}/licencias/{$license->id}",
                'map'
            );

            $newData['mapa_ubicacion']    = $uploadedFile['path'];
            $newData['mapa_url']          = $uploadedFile['url'];

            $property = Property::firstWhere('license_id', $license->id);
            $property->fill($newData);
            $license->property()->save($property);


        } catch (\Throwable $th) {
            abort(500, 'No se ha podido guardar el mapa, intentelo más tarde '. $th->getMessage());
        }
        return response()->json($license->load([
            'licenseType', 'applicant', 'property',
            'backgrounds', 'construction', 'owner',
            'validity', 'requirements', 'ad',
            'validations', 'observations',
            'order', 'order.duties', 'applicant.applicantData',
            'compatibilityCertificate', 'SFD'
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
        if ($request->estatus == 1) {
            $responseEvent = event(new RequestValidated(request()->user(), $license));
            abort_if($responseEvent[0] == 'false',403,'No ha cargado todos los documentos obligatorios');
        }

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

    public function sublicense(UpdateLicenseRequest $request, License $license)
    {
        $this->authorize('store', License::class, $request->license_type_id);

        $type = request()->query('type');

        $user = $request->user();

        $priorLicense   = $license;
        // $licenseData    = $request->validated();
        $license        = new License([
            'license_type_id' => $type == true ? 23 : 6,
            'estatus'         => 1
        ]);

        DB::beginTransaction();
        try {
            $license->save();

            mkdir(storage_path("app/public/solicitantes/{$priorLicense->user_id}/licencias/{$license->id}"));
            if ($request->license_type_id != 20){//? vehicle ad
                //?propety description

                $property = Property::firstWhere('license_id', $priorLicense->id);
                $newProperty = $property->replicate();
                $newProperty->license_id = $license->id;

                copy(
                    storage_path('app/'.$property->mapa_ubicacion),
                    storage_path("app/public/solicitantes/{$license->user_id}/licencias/{$license->id}/map.png"));

                $newProperty->mapa_ubicacion    = "public/solicitantes/{$license->user_id}/licencias/{$license->id}/map.png";
                $newProperty->mapa_url          = "/storage/solicitantes/{$license->user_id}/licencias/{$license->id}/map.png";

                $newProperty->save();
                // self::copyProperty($request, $license);
            }

            //? numbers in db, id license type
            if  ($priorLicense->license_type_id >= 1 && $priorLicense->license_type_id <= 6 ||
                ($priorLicense->license_type_id >= 8 && $priorLicense->license_type_id <= 11) ||
                ($priorLicense->license_type_id == 15) ||
                ($priorLicense->license_type_id >= 24 && $priorLicense->license_type_id <= 28)
            ) { //? permisos de construccion
               //?backgrounds
                if ($request->backgrounds[0] <> null) {
                    self::saveBackgrounds($request, $license);
                }

                //?construction description
                $constDesc = ConstructionDescription::firstWhere('license_id', $priorLicense->id);
                $newconstDesc = $constDesc->replicate();
                $newconstDesc->license_id = $license->id;
                $newconstDesc->save();
                // self::saveConstructionDescriptions($request, $license);

                $constOwner = ConstructionOwner::firstWhere('license_id', $priorLicense->id);
                $newconstOwner = $constOwner->replicate();
                $newconstOwner->license_id = $license->id;
                $newconstOwner->save();
                // self::copyConstructionOwner($request, $license);
            }

            if ($priorLicense->license_type_id == 7 || $priorLicense->license_type_id == 24) {
                //posible aliminacion de este if, no necesita prorroga
                // no oficial | romper pavimento
                $constOwner = ConstructionOwner::firstWhere('license_id', $priorLicense->id);
                $newconstOwner = $constOwner->replicate();
                $newconstOwner->license_id = $license->id;
                $newconstOwner->save();
            }

            if ($request->license_type_id == 16) {//? constancia compatibilidad
                $compatibility = CompatibilityCertificate::firstWhere('license_id', $priorLicense->id);
                $newCompatibility = $compatibility->replicate();
                $newCompatibility->license_id = $license->id;
                $newCompatibility->save();
                // self::saveCompatibilityCertificate($request, $license);
            }

            if ($request->license_type_id >= 17 && $request->license_type_id <= 20) {//? anuncios
                $adDescription = AdDescription::firstWhere('license_id', $priorLicense->id);
                $newAdDescription = $adDescription->replicate();
                $newAdDescription->license_id = $license->id;
                $newAdDescription->save();
                // self::saveAdDescription($request, $license);
            }

            if ($request->license_type_id >= 22) {//? sfd
                $sfd = SFD::firstWhere('license_id', $priorLicense->id);
                $newSfd = $sfd->replicate();
                $newSfd->license_id = $license->id;
                $newSfd->save();
                self::saveSFD($request, $license);
            }

            if ($type){//?termination
                //?array created to can use saveRequirements method in store and sublicense function
                // $data = [ 'license_type_id' => $priorLicense->license_type_id ];
                // self::saveRequirements($data, $license);

                self::copyRequirements($priorLicense, $license);
            }else{//?extension
                self::saveExtRequirement($license);
                //?copy requirement's file form old license
                self::copyExtRequirement($priorLicense, $license);
            }


        } catch (\Throwable $th) {
            DB::rollBack();
            $this->storage
                ->deleteDirectory("public/solicitantes/{$user->id}/licencias/{$license->id}");
            abort(500, 'No se ha podido generar la licencia, intentelo más tarde '. $th->getMessage());
        }
        DB::commit();

        return response()->json($license, 200);
    }

    /**
     * save property informarion
     * @param json $request
     * @param License $license
     * @return void
     */
    public function saveProperty($request, $license)
    {
        $property = new Property($request->property);
        $uploadedFile = $this->storage->uploadBase64File(
            $request->property['mapa'],
            "public/solicitantes/{$license->user_id}/licencias/{$license->id}",
            'map'
        );

        $property->mapa_ubicacion    = $uploadedFile['path'];
        $property->mapa_url          = $uploadedFile['url'];

        $license->property()->save($property);
    }

    /**
     * save backgrounds informarion
     * @param json $request
     * @param License $license
     * @return void
     */
    public function saveBackgrounds($request, $license)
    {
        $backgrounds = collect($request->backgrounds)->map(function ($background) use($license){
            $background['current_license_id'] = $license->id;
            return new ConstructionBackground($background);
        });
        $license->backgrounds()->saveMany($backgrounds);
    }

    /**
     * save construction description informarion
     * @param json $request
     * @param License $license
     * @return void
     */
    public function saveConstructionDescriptions($request, $license)
    {
        $description =  new ConstructionDescription($request->construction);
        $license->construction()->save($description);
    }

    /**
     * save Construction Owner informarion
     * @param json $request
     * @param License $license
     * @param User $user
     * @return void
     */
    public function saveConstructionOwner($request, $license, $user)
    {
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

    /**
     * save Compatibility Certificate informarion
     * @param json $request
     * @param License $license
     * @return void
     */
    public function saveCompatibilityCertificate($request, $license)
    {
        $compatibility = new CompatibilityCertificate($request->uses);
        $license->compatibilityCertificate()->save($compatibility);
    }

    /**
     * save Ad Descriptione informarion
     * @param json $request
     * @param License $license
     * @return void
     */
    public function saveAdDescription($request, $license)
    {
        $ad = new AdDescription($request->ad);
        $license->ad()->save($ad);
    }

    /**
     * save save SFD informarion
     * @param json $request
     * @param License $license
     * @return void
     */
    public function saveSFD($request, $license)
    {
        $sfd = new SFD($request->sfd);
        $license->sfd()->save($sfd);
    }

    /**
     * save Requirement informarion
     * @param json $request
     * @param License $license
     * @return void
     */
    public function saveRequirements($licenseData, $license)
    {
        $requirements = Requirement::where('license_type_id',$licenseData['license_type_id'])->get();
        $requirementsData = collect($requirements)->map(function ($requiment) use ($license) {
            $data['requirement_id'] = $requiment['id'];
            $data['license_id'] = $license->id;
            return new LicenseRequirement($data);
        });
        $license->requirements()->saveMany($requirementsData);
    }

    /**
     * copy Lic Requirement pdf and update db regist only extension
     * @param json $request
     * @param License $license
     * @return void
     */
    public function copyExtRequirement($priorLicense, $license)
    {
        // mkdir(storage_path("app/public/solicitantes/{$license->user_id}/licencias/{$license->id}"));
        copy(
            storage_path("app/public/solicitantes/{$license->user_id}/licencias/".$priorLicense->id."/{$priorLicense->folio}.pdf"),
            storage_path("app/public/solicitantes/{$license->user_id}/licencias/{$license->id}/{$priorLicense->folio}.pdf"));

        $requirement = LicenseRequirement::where('license_id', $license->id)->first();

        $requirement->archivo_ubicacion    = "public/solicitantes/{$license->user_id}/licencias/".$license->id."/{$priorLicense->folio}.pdf";
        $requirement->archivo_url          = "/storage/solicitantes/{$license->user_id}/licencias/".$license->id."/{$priorLicense->folio}.pdf";
        $requirement->archivo_nombre       = $priorLicense->folio;
        $requirement->estatus              = 4;
        $requirement->fecha_autorizacion = Carbon::now();

        $requirement->save();
    }

    /**
     * save Requirement, extensions only
     * @param json $request
     * @param License $license
     * @return void
     */
    public function saveExtRequirement($license)
    {
        $requirements = Requirement::where('license_type_id',$license->license_type_id)->get();
        $requirementsData = collect($requirements)->map(function ($requiment) use ($license) {
            $data['requirement_id'] = $requiment['id'];
            $data['license_id'] = $license->id;
            return new LicenseRequirement($data);
        });
        $license->requirements()->saveMany($requirementsData);
    }

    /**
     * save Requirements file
     * @param License $priorLicense
     * @param License $license
     * @return void
     */
    public function copyRequirements($priorLicense, $license)
    {
        mkdir(storage_path("app/public/solicitantes/{$license->user_id}/licencias/{$license->id}/requisitos"));
        $requirements = LicenseRequirement::where('license_id',$priorLicense->id)->get();
        collect($requirements)->map(function ($requiment) use ($license, $priorLicense) {
            $newRequirement = $requiment->replicate();
            $newRequirement->license_id = $license->id;

            if (!is_null($requiment->archivo_nombre)) {
                copy(
                    storage_path("app/public/solicitantes/{$license->user_id}/licencias/{$priorLicense->id}/requisitos/{$requiment->archivo_nombre}"),
                    storage_path("app/public/solicitantes/{$license->user_id}/licencias/{$license->id}/requisitos/{$requiment->archivo_nombre}"));

                $newRequirement->archivo_ubicacion  = "public/solicitantes/{$license->user_id}/licencias/".$license->id."/{$requiment->archivo_nombre}";
                $newRequirement->archivo_url        = "/storage/solicitantes/{$license->user_id}/licencias/".$license->id."/{$requiment->archivo_nombre}";
            }
            $newRequirement->save();
        });
    }

    /**
     * update licensen backgrounds
     * @param json $request
     * @param License $license
     * @return void
     */
    public function updateBackgrounds($request, $license)
    {
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
