<?php

namespace App\Services;

use App\Interfaces\IStoreLicenseService;
use App\Models\AdDescription;
use App\Models\CompatibilityCertificate;
use App\Models\ConstructionBackground;
use App\Models\ConstructionDescription;
use App\Models\ConstructionOwner;
use App\Models\LicenseRequirement;
use App\Models\LicenseValidity;
use App\Models\Lot;
use App\Models\Property;
use App\Models\Requirement;
use App\Models\SelfBuild;
use App\Models\SFD;
use App\Models\StructuralSafetyCertificate;
use Carbon\Carbon;
use Exception;

class StoreLicenseService implements IStoreLicenseService
{
    protected $numberConversion;
    protected $storage;

    public function __construct()
    {
        $this->numberConversion = new NumberConversionService();
        $this->storage = new StorageService();
    }


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

        if ($license->property()->save($property)){
            return $property;
        }

        throw new Exception("Error saving property", 1);
    }

    public function saveBackgrounds($request, $license)
    {
        $backgrounds = collect($request->backgrounds)->map(function ($background) use($license){
            $background['current_license_id'] = $license->id;
            return new ConstructionBackground($background);
        });

        if ($license->backgrounds()->saveMany($backgrounds)){
            return $backgrounds;
        }

        throw new Exception("Error saving backgrounds", 1);
    }

    public function saveConstructionDescriptions($request, $license)
    {
        $description =  new ConstructionDescription($request->construction);

        if ($license->construction()->save($description)){
            return $description;
        }

        throw new Exception("Error saving construction description", 1);
    }

    public function saveConstructionOwner($request, $license, $user)
    {
        // if($request->user()->hasRole('dro')){
        if(!isset($request->owner['ownerFlag']) || !$request->owner['ownerFlag']){
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
        if($license->owner()->save($owner)){
            return $owner;
        }

        throw new Exception("Error saving construction owner", 1);
    }

    public function saveSafety($request, $license)
    {
        $safety = new StructuralSafetyCertificate($request->safety);
        if($license->safety()->save($safety)){
            return $safety;
        }

        throw new Exception("Error saving structural safety", 1);
    }

    public function saveCompatibilityCertificate($request, $license)
    {
        $compatibility = new CompatibilityCertificate($request->uses);
        if($license->compatibilityCertificate()->save($compatibility)){
            return $compatibility;
        }

        throw new Exception("Error saving compatibility certificate", 1);
    }

    public function saveSFD($request, $license)
    {
        $sfds = collect($request->s_f_d['actividades'])->map(function($actividad) use($license){
            $sfd = new SFD($actividad);
            $license->sfd()->save($sfd);

            if (isset($actividad['lotes'])) {
                $lots = collect($actividad['lotes'])->map(function($lote) use($license){
                    $lot = new Lot($lote);
                    $lot->license_id = $license->id;
                    return $lot;
                });
                $sfd->lots()->saveMany($lots);
            }
        });

        return $sfds;

        throw new Exception("Error saving SFD", 1);
    }

    public function updateSFD($request, $license)
    {
        $sfds = collect($request->s_f_d)->map(function($actividad) use($license){
            if (isset($actividad['id'])) {
                $sfd = SFD::find($actividad['id']);
                $sfd->fill($actividad);
                $sfd->sustento = $actividad['sustento'];
                $sfd->save();
            }else {
                $sfd = new SFD($actividad);
                $license->sfd()->save($sfd);
            }

            collect($actividad['lots'])->map(function($lote) use($sfd, $license){
                if (isset($lote['id'])) {
                    $lot = Lot::find($lote['id']);
                    $lot->fill($lote);
                    $lot->save();
                }else {
                    $lot = new Lot($lote);
                    $lot->license_id = $license->id;
                    $lot->s_f_d_id = $sfd->id;
                    $lot->save();
                }
            });
        });

        return $sfds;

        throw new Exception("Error updating SFD", 1);
    }

    public function saveValidity($request, $license)
    {
        $validity = LicenseValidity::firstWhere('license_id', $license->id);
        $diff = date_diff(date_create($request->validity['fecha_autorizacion']), date_create($request->validity['fecha_fin_vigencia']));

        $validityData = [
            'dias_total' => $diff->format("%a"),
            'fecha_autorizacion' => $request->validity['fecha_autorizacion'],
            'fecha_fin_vigencia' => $request->validity['fecha_fin_vigencia'],
            'observation' => $request->validity['observation'] ?? null
        ];
        if (is_null($validity)) $validity = new LicenseValidity($validityData);
        else $validity->fill($validityData);

        if($license->validity()->save($validity)){
            return $validity;
        }

        throw new Exception("Error saving validity", 1);
    }

    public function saveAdDescription($request, $license)
    {
        $ads = collect($request->ads)->map(function ($ad){
            $ad['colocacion'] = 'Colocación';
            return new AdDescription($ad);
        });
        $license->ads()->saveMany($ads);

        if (is_null($request->ad)) {
            $dates = [
                'validity' => [
                    'fecha_autorizacion' => Carbon::now()->format('Y-m-d'),
                    //last day of current year
                    'fecha_fin_vigencia' => Carbon::now()->endOfYear()->format('Y-m-d'),
                ],
            ];
        }else {
            $dates = [
                'validity' => [
                    'fecha_autorizacion' => Carbon::now()->format('Y-m-d'),
                    //last day of current year
                    'fecha_fin_vigencia' => Carbon::now()->addMonths($request->ad['meses'])->format('Y-m-d'),
                ],
            ];
        }

        self::saveValidity((object)$dates, $license);

        return $ads;

        throw new Exception("Error saving ad description", 1);
    }

    public function saveRequirements($licenseData, $license)
    {
        $requirements = Requirement::where('license_type_id',$licenseData['license_type_id'])->get();
        $requirementsData = collect($requirements)->map(function ($requiment) use ($license) {
            $data['requirement_id'] = $requiment['id'];
            $data['license_id'] = $license->id;
            return new LicenseRequirement($data);
        });

        if($license->requirements()->saveMany($requirementsData)){
            return $requirementsData;
        }

        throw new Exception("Error saving requirements", 1);
    }

    public function saveSelfBuild($request, $license)
    {
        $selfBuild = new selfBuild($request->self_build);
        if($license->selfBuild()->save($selfBuild)){
            return $selfBuild;
        }

        throw new Exception("Error saving self build", 1);
    }

    public function updateBackgrounds($request, $license)
    {
        $backgrounds = collect($request->backgrounds)->map(function ($item) use($license){
            if (isset($item['id'])) {
                $background = ConstructionBackground::firstWhere('id', $item['id']);
                logger($background);
                $background->fill($item);
            }else {
                $background = new ConstructionBackground($item);
                $background['current_license_id'] = $license->id;
            }
            return $background;
        });
        if($license->backgrounds()->saveMany($backgrounds)){
            return $backgrounds;
        }

        throw new Exception("Error saving backgrounds", 1);
    }
}
