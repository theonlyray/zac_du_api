<?php

namespace App\Http\Controllers\Licenses;

use App\Events\ApiOPQueried;
use App\Events\RequestValidated;
use App\Exports\LicensesExport;
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
use App\Models\ConstructionOwner;
use App\Models\License;
use App\Models\LicenseObservation;
use App\Models\LicenseRequirement;
use App\Models\LicenseValidation;
use App\Models\Lot;
use App\Models\Property;
use App\Models\Requirement;
use App\Models\SelfBuild;
use App\Models\SFD;
use App\Models\StructuralSafetyCertificate;
use App\Services\CheckLicenseType;
use App\Services\StorageService;
use App\Services\StoreLicenseService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Crypt;
use Maatwebsite\Excel\Facades\Excel;

class LicenseController extends Controller
{
    protected $storage;
    protected $checkLicenseType;
    protected $storeLicenseServer;
    protected $loadArrays;
    protected $IStoreLicenseService;

    public function __construct(StorageService $storage)
    {
        $this->storage = $storage;
        $this->checkLicenseType = new CheckLicenseType();
        // $this->IStoreLicenseService = new StoreLicenseService($storage);
        $this->IStoreLicenseService = new StoreLicenseService();
        $this->loadArrays = [
            'licenseType', 'applicant', 'property',
            'backgrounds', 'construction', 'owner',
            'validity', 'requirements', 'ads',
            'validations', 'observations',
            'order', 'order.duties', 'applicant.applicantData',
            'compatibilityCertificate',
            'compatibilityCertificate.LandUse',
            'compatibilityCertificate.LandUseDescription',
            'SFD', 'safety', 'selfBuild', 'SFD.lots',
        ];
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
        $licenses = License::where('estatus', 6)->get(['id','folio']);

        abort_if($licenses->isEmpty(), 204, 'No se encontraron licencias.');

        return response()->json($licenses, 200);
    }

    public function index()
    {
        $this->authorize('index', License::class);

        $user   = request()->user();
        $status = request()->query('estatus');

        $allowsParams = collect(['Preparación', 'Proceso', 'Autorizadas', 'Canceladas', 'Rechazadas']);
        $isAllowed = $allowsParams->first(function ($item) use ($status){
            return $item == $status;
        });

        abort_if($isAllowed === null, 400, 'Petición no aceptada, parametros incorrectos o faltantes. '. $status .  ' ');

        $licenses = License::getLicencesList($user, $status);

        abort_if($licenses->isEmpty(), 204, 'No se encontraron licencias.');

        if ($status == 'Autorizadas') {
            self::saveRecibo($licenses);
        }

        return response()->json($licenses, 200);
    }

    public function show(License $license)
    {
        $this->authorize('show', [License::class, $license]);

        return response()->json($license->load($this->loadArrays), 200);
    }

    public function store(StoreLicenseRequest $request)
    {
        $this->authorize('store', License::class, $request->license_type_id);

        $user = $request->user();

        $licenseData    = $request->validated();
        $license        = new License($licenseData);

        $licenseType = $this->checkLicenseType->checkLicenseType($request->license_type_id);

        DB::beginTransaction();
        try {
            $license->save();
            if ($licenseType != 'vehicle_ad' && $licenseType != 'self-build') {
                $this->IStoreLicenseService->saveProperty($request, $license);
                // self::saveProperty($request, $license);
            }

            if ($licenseType == 'construction' || $licenseType == 'break_pavement' || $licenseType == 'completion') {
                //?backgrounds
                if ($licenseType != 'break_pavement') {
                    if ($request->backgrounds[0] <> null) {
                        $this->IStoreLicenseService->saveBackgrounds($request, $license);
                    }
                }

                //?construction description
                $this->IStoreLicenseService->saveConstructionDescriptions($request, $license);

                $this->IStoreLicenseService->saveConstructionOwner($request, $license, $user);
            }

            if ($licenseType == 'oficial_number' || $licenseType == 'urban_services' ||
                $licenseType == 'sfd' ||  $licenseType == 'alignment') {
                    $this->IStoreLicenseService->saveConstructionOwner($request, $license, $user);
            }

            if ($licenseType == 'self-build') {
                $this->IStoreLicenseService->saveBackgrounds($request, $license);
                $this->IStoreLicenseService->saveSelfBuild($request, $license);
            }

            if ($licenseType == 'safety') {
                $this->IStoreLicenseService->saveSafety($request, $license);
                $this->IStoreLicenseService->saveConstructionOwner($request, $license, $user);
            }

            if ($licenseType == 'compatibility') {
                $this->IStoreLicenseService->saveCompatibilityCertificate($request, $license);
            }

            if ($licenseType == 'ad' || $licenseType == 'vehicle_ad') {//? ads
                $this->IStoreLicenseService->saveAdDescription($request, $license);
            }

            if ($licenseType == 'sfd') {//? sfd
                $this->IStoreLicenseService->saveSFD($request, $license);
            }

            if (!is_null($request->validity)) {
                if (!is_null($request->validity['fecha_autorizacion']) && !is_null($request->validity['fecha_fin_vigencia'])) {
                    $this->IStoreLicenseService->saveValidity($request, $license);
                }
            }

            $this->IStoreLicenseService->saveRequirements($licenseData, $license);

            Storage::makeDirectory("public/solicitantes/{$user->id}/licencias/{$license->id}", 0777, true);

            $this->generateQR(null, $license);
        } catch (\Throwable $th) {
            DB::rollBack();
            logger($th);
            $this->storage
                ->deleteDirectory("public/solicitantes/{$user->id}/licencias/{$license->id}");
            abort(500, 'No se ha podido generar la licencia, intentelo más tarde '. $th->getMessage());
        }
        DB::commit();

        return response()->json($license, 200);
    }

    public function update(UpdateLicenseRequest $request, License $license)
    {
        $this->authorize('update', [License::class, $license]);

        DB::beginTransaction();

        $licenseType = $this->checkLicenseType->checkLicenseType($request->license_type_id);

        try {
            $data = $request->validated();
            $license->fill($data);
            $license->save();

            if ($licenseType != 'vehicle-ad' && $licenseType != 'self-build'){
                $property = Property::firstWhere('license_id', $license->id);
                $property->fill($request->property);
                $property->save();
            }

            if ($licenseType != 'vehicle-ad' && $licenseType != 'self-build' && $licenseType != 'compatibility'){
                //saving owner data
                $owner = ConstructionOwner::firstWhere('license_id', $license->id);
                //fill or create
                if (is_null($owner)) {
                    $owner = new ConstructionOwner($request->owner);
                    $license->owner()->save($owner);
                } else {
                    $owner->fill($request->owner);
                    $owner->save();
                }
            }


            //? numbers in db, id license type
            if ($licenseType == 'construction' || $licenseType == 'completion' || $licenseType == 'break_pavement') { //? permisos de construccion
                $description = ConstructionDescription::firstWhere('license_id', $license->id);
                $description->fill($request->construction);

                $license->construction()->save($description);

                $owner = ConstructionOwner::firstWhere('license_id', $license->id);
                $owner->fill($request->owner);
                $license->owner()->save($owner);

                if (!empty($request->backgrounds) && $licenseType != 'completion' && $licenseType != 'break_pavement') {
                    $this->IStoreLicenseService->updateBackgrounds($request, $license);
                }
            }

            if ($licenseType == 'oficial_number' || $licenseType == 'urban_services' ||
                $licenseType == 'sfd' || $licenseType == 'alignment') {
                //?no oficial | romper pavimento
                $owner = ConstructionOwner::firstWhere('license_id', $license->id);
                $owner->fill($request->owner);
                $license->owner()->save($owner);
            }

            if ($licenseType == 'self-build') {
                //?constancia autoconstruccion
                $this->IStoreLicenseService->updateBackgrounds($request, $license);
                $selfBuild = SelfBuild::firstWhere('license_id', $license->id) ?? new SelfBuild();
                $selfBuild->fill($request->self_build);
                $license->selfBuild()->save($selfBuild);
            }

            if ($licenseType == 'safety') {
                //?seguridad estructural
                $safety = StructuralSafetyCertificate::firstWhere('license_id', $license->id);
                $safety->fill($request->safety);
                $license->safety()->save($safety);

                $owner = ConstructionOwner::firstWhere('license_id', $license->id);
                $owner->fill($request->owner);
                $license->owner()->save($owner);
            }

            if ($licenseType == 'compatibility') {//? compatibilityCertificate
                $compatibilityCertificate = CompatibilityCertificate::firstWhere('license_id', $license->id);
                $compatibilityCertificate->fill($request->compatibility_certificate);
                $license->compatibilityCertificate()->save($compatibilityCertificate);
            }

            if ($licenseType == 'ad' || $licenseType == 'vehicle_ad') {//? anuncios
                //query and update each ad in request
                foreach ($request->ads as $rad) {
                    $ad = AdDescription::find($rad['id']);
                    $ad->fill($rad);
                    $ad->save();
                }
            }

            if ($licenseType == 'sfd') {//? sfd
                $this->IStoreLicenseService->updateSFD($request, $license);
            }

            if (!is_null($request->validity)) {
                if (!is_null($request->validity['fecha_autorizacion']) && !is_null($request->validity['fecha_fin_vigencia'])) {
                    $this->IStoreLicenseService->saveValidity($request, $license);
                }
            }

        } catch (\Throwable $th) {
            logger($th);
            DB::rollBack();
            abort(500, 'No se ha podido actualizar la licencia, intentelo más tarde '. $th->getMessage());
        }
        DB::commit();

        return response()->json($license->load($this->loadArrays), 200);
    }

    public function updateMap(UpdateLicenseMapRequest $request, License $license)
    {
        $this->authorize('update', [License::class, $license]);

        $user = $request->user();

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
            'validity', 'requirements', 'ads',
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

    public function sfd(License $license, SFD $sfd)
    {

        $this->authorize('update', [License::class, $license]);

        DB::beginTransaction();
        try {
            SFD::where('id', $sfd->id)->delete();
        } catch (\Throwable $th) {
            DB::rollBack();
            abort(500, 'No se ha podido eliminar la actividad, intentelo más tarde '. $th);
        }

        DB::commit();

        return response()->json($license->load($this->loadArrays), 200);
    }

    public function lot(License $license, Lot $lot)
    {

        $this->authorize('update', [License::class, $license]);

        DB::beginTransaction();
        try {
            Lot::where('id', $lot->id)->delete();
        } catch (\Throwable $th) {
            DB::rollBack();
            abort(500, 'No se ha podido eliminar el lote, intentelo más tarde '. $th);
        }

        DB::commit();

        return response()->json($license->load($this->loadArrays), 200);
    }

    public function ad(License $license, AdDescription $ad)
    {

        $this->authorize('update', [License::class, $license]);

        DB::beginTransaction();
        try {
            AdDescription::where('id', $ad->id)->delete();
        } catch (\Throwable $th) {
            DB::rollBack();
            abort(500, 'No se ha podido eliminar el anuncio, intentelo más tarde '. $th);
        }

        DB::commit();

        return response()->json($license->load([
            'licenseType', 'applicant', 'property',
            'backgrounds', 'construction', 'owner',
            'validity', 'requirements', 'validations',
            'observations', 'ads'
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
            logger($th);
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
            if ($request->estatus == 8) {
                $uploadedFile = $this->storage->saveDocumentBlueprint(
                    $request->file['base64'],
                    "public/solicitantes/{$license->user_id}/licencias/{$license->id}/rechazo",
                    $request->file['filename']
                );

                $observation->path    = $uploadedFile['path'];
                $observation->url     = $uploadedFile['url'];
            }

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
        //?Docs y Planos Validados || Autorizada
        if ($request->estatus == 4 || $request->estatus == 6) {
            try {
                $validition = new LicenseValidation(['user_id' => $user->id, 'descripcion' => $license->estatus]);
                $license->validations()->save($validition);

                self::obsSolved($license);

            } catch (\Throwable $th) {
                DB::rollBack();
                return 'Error al generar validación '. $th->getMessage();
            }
        }
        if ($request->estatus == 3) {//'obs corregidas
            self::obsSolved($license);
        }

        $license->save();
        DB::commit();

        return response()->json($license->load('licenseType', 'applicant', 'property',
            'backgrounds', 'construction', 'owner',
            'validity', 'requirements', 'validations',
            'observations'), 200);
    }

    private function obsSolved(License $license)
    {
        $observations = LicenseObservation::where([
            ['created_at', '<=', Carbon::now()],
            ['license_id', $license->id]
        ])
        ->get(); //get observations befo current validation

        $observations = $observations->map(function ($observation){
            $observation->solventada = true; //?if theres a new validation old observations must be solved
                return $observation->save();
        });
    }

    public function sublicense(UpdateLicenseRequest $request, License $license)
    {
        $this->authorize('store', License::class, $request->license_type_id);

        $type = request()->query('type');

        $user = $request->user();

        $priorLicense   = $license;
        // $licenseData    = $request->validated();
        $license        = new License([
            'license_type_id' => $type == 'true' ? 23 : 6,
            'estatus'         => 1
        ]);

        $licenseType = $this->checkLicenseType->checkLicenseType($request->license_type_id);

        DB::beginTransaction();
        try {
            $license->save();

            // mkdir(storage_path("app/public/solicitantes/{$priorLicense->user_id}/licencias/{$license->id}"));
            Storage::makeDirectory("public/solicitantes/{$user->id}/licencias/{$license->id}", 0777, true);

            if ($licenseType != 'vehicle-ad'){//? vehicle ad
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
            if  ($licenseType == 'construction') { //? permisos de construccion
               //?backgrounds
                if ($request->backgrounds[0] <> null) {
                    $this->IStoreLicenseService->saveBackgrounds($request, $license);
                }

                //?construction description
                $constDesc = ConstructionDescription::firstWhere('license_id', $priorLicense->id);
                $newconstDesc = $constDesc->replicate();
                $newconstDesc->license_id = $license->id;
                $newconstDesc->save();

                $constOwner = ConstructionOwner::firstWhere('license_id', $priorLicense->id);
                $newconstOwner = $constOwner->replicate();
                $newconstOwner->license_id = $license->id;
                $newconstOwner->save();
            }

            // if ($type){//?termination
                //?array created to can use saveRequirements method in store and sublicense function

                self::copyRequirements($priorLicense, $license);
            // }else{//?extension
                self::saveExtRequirement($license);
                //?copy requirement's file form old license
                self::copyExtRequirement($priorLicense, $license);
            // }

            Storage::makeDirectory("public/solicitantes/{$user->id}/licencias/{$license->id}", 0777, true);

            $this->generateQR(null, $license);

        } catch (\Throwable $th) {
            DB::rollBack();
            $this->storage
                ->deleteDirectory("public/solicitantes/{$user->id}/licencias/{$license->id}");
            abort(500, 'No se ha podido generar la licencia, intentelo más tarde '. $th->getMessage());
        }
        DB::commit();

        return response()->json($license, 200);
    }

    public function countersign(UpdateLicenseRequest $request, License $license)
    {
        $this->authorize('store', License::class, $request->license_type_id);

        $user = $request->user();

        $priorLicense   = $license;
        // $licenseData    = $request->validated();
        $license        = new License([
            'license_type_id' => $license->license_type_id,
            'estatus'         => 1
        ]);

        DB::beginTransaction();
        try {
            $license->save();

            // mkdir(storage_path("app/public/solicitantes/{$priorLicense->user_id}/licencias/{$license->id}"));
            Storage::makeDirectory("public/solicitantes/{$user->id}/licencias/{$license->id}", 0777, true);

            $property = Property::firstWhere('license_id', $priorLicense->id);
            $newProperty = $property->replicate();
            $newProperty->license_id = $license->id;

            copy(
                storage_path('app/'.$property->mapa_ubicacion),
                storage_path("app/public/solicitantes/{$license->user_id}/licencias/{$license->id}/map.png"));

            $newProperty->mapa_ubicacion    = "public/solicitantes/{$license->user_id}/licencias/{$license->id}/map.png";
            $newProperty->mapa_url          = "/storage/solicitantes/{$license->user_id}/licencias/{$license->id}/map.png";

            $newProperty->save();

            //get all ads from prior license and replicate them to new license
            $ads = AdDescription::where('license_id', $priorLicense->id)->get();
            foreach ($ads as $ad) {
                $newAd = $ad->replicate();
                $newAd->colocacion = "Renovación";
                $newAd->license_id = $license->id;
                $newAd->save();
            }


            self::copyRequirements($priorLicense, $license);

            $dates = [
                'validity' => [
                    'fecha_autorizacion' => Carbon::now()->format('Y-m-d'),
                    //last day of current year
                    'fecha_fin_vigencia' => Carbon::now()->endOfYear()->format('Y-m-d'),
                ],
            ];

            $this->IStoreLicenseService->saveValidity((object)$dates, $license);

            if ($request->backgrounds[0] <> null) {
                $this->IStoreLicenseService->saveBackgrounds($request, $license);
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

    public function generateQR(Request $request = null, License $license)
    {
        $this->authorize('update', [License::class, $license]);

        try {
            //hash folio base64
            $folio = Crypt::encryptString($license->folio);
            $response = Http::get(
                "https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=https://permisos.capitaldezacatecas.gob.mx/verify.html?uuid=$folio&choe=UTF-8");
            Storage::disk('local')->put("public/solicitantes/{$license->user_id}/licencias/{$license->id}/qr.png", $response->body(), 'public');
            //get url of qr
            $url = Storage::url("public/solicitantes/{$license->user_id}/licencias/{$license->id}/qr.png");
            //save url in license
            $license->qr_code = $url;
            $license->save();
        } catch (\Throwable $th) {
            abort(500, 'No se ha podido generar el código QR, intentelo más tarde '. $th->getMessage());
        }

        return response()->json($license->load($this->loadArrays), 200);
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

                $newRequirement->archivo_ubicacion  = "public/solicitantes/{$license->user_id}/licencias/".$license->id."/requisitos/{$requiment->archivo_nombre}";
                $newRequirement->archivo_url        = "/storage/solicitantes/{$license->user_id}/licencias/".$license->id."/requisitos/{$requiment->archivo_nombre}";
            }
            $newRequirement->save();
        });
    }

    /**
     * export licenses report
     * @param Request $request
     */
    public function export(Request $request)
    {
        $this->authorize('index', License::class);

        return Excel::download((new LicensesExport)
            ->forStatus($request->status)
            ->forDates($request->init ?? null, $request->finish ?? null),
            'licencias.xlsx');
    }

    /**
     * query url_recibo and save in license table
     */
    private function saveRecibo($licenses){
        $event = event(new ApiOPQueried(null));
        $token = $event[0];

        foreach ($licenses as $license) {
            if ($license->url_recibo == null) {
                $response = Http::withHeaders([
                    'Authorization' => "Bearer {$token}",
                ])
                ->acceptJson()
                ->post('https://sefin.capitaldezacatecas.gob.mx/api/orden/folioCheck', [
                    'folio' => $license->order->folio_api,
                ]);

                abort_if(!$response->successful(),500,"Error de consulta (API), intentelo más tarde.
                 {$license->order->folio_api}");

                $response = (json_decode($response));
                if (!is_null($response->urlFiles)) {
                    $license->url_recibo = $response->urlFiles;
                    $license->save();
                }
            }
        }

    }

}
