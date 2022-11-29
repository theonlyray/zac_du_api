<?php

namespace App\Http\Controllers\Pdfs;

use App\Http\Controllers\Controller;
use App\Models\ApplicantData;
use App\Models\CompatibilityCertificate;
use App\Models\ConstructionBackground;
use App\Models\Department;
use App\Models\License;
use App\Models\LicenseType;
use App\Models\LicenseValidation;
use App\Models\Order;
use App\Models\StructuralSafetyCertificate;
use App\Models\User;
use App\Services\CheckLicenseType;
use App\Services\NumberConversionService;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class PdfController extends Controller
{

    protected $checkLicenseType;

    public function __construct()
    {
        $this->data = [];
        $this->template = '';
        $this->checkLicenseType = new CheckLicenseType();
    }

    public function preview(License $license)//?preview license
    {
        self::getData($license);
        self::getTemplate($license, true);

        $pdf = PDF::loadView($this->template, $this->data)->setPaper('letter', 'portrait');

        return $pdf->stream();
    }

    public function request(License $license) //? request pdf
    {
        self::getData($license);
        self::getTemplate($license, false);

        $pdf = PDF::loadView($this->template, $this->data)->setPaper('letter', 'portrait');

        return $pdf->stream();
    }

    public function license(License $license)//?download license signed
    {
        return response()->download(
            storage_path("app/public/solicitantes/{$license->user_id}/licencias/{$license->id}/{$license->folio}.pdf"),
            "{$license->folio}.pdf"
        );
    }

    public function getData(License $license)
    {
        $licenseType = $this->checkLicenseType->checkLicenseType($license->license_type_id);

        $license->load(['licenseType', 'applicant',
            'applicant.applicantData','property',
            'backgrounds', 'construction', 'owner',
            'validity', 'requirements', 'ad',
            'validations', 'observations',
            'order', 'order.duties']);

        $applicant = User::where('id', $license->user_id)
            ->with('applicantData')
            ->get();

        $applicantData = ApplicantData::where('user_id',$license->user_id)->get();

        $dirSDUMA = User::role('jefeSDUMA')->get();



        $this->data = [
            'license'       => $license,
            'applicant'     => $applicant[0],
            'applicantData' => $applicantData[0],
            'dirSDUMA'      => $dirSDUMA[0],
            'dirDep'        => self::getDepDir($license)[0],
        ];

        if( $licenseType == 'construction'){  //?construction
            $backgrounds = ConstructionBackground::where('current_license_id',$license->id)
                ->with('priorLicense')->get();

            $priorLicenseIds = $backgrounds->pluck('prior_license_id')->toArray();
            $priorLicenseIds = collect($priorLicenseIds)->filter(function ($value, $key) {
                return $value != null;
            });
            $priorLicenses = License::whereIn('id',$priorLicenseIds)->get(['folio','fecha_actualizacion']);

            $this->data['backgrounds']      = $backgrounds;
            $this->data['priorLicenses']    = $priorLicenses;
        }else if($licenseType == 'vehicle_ad' && $licenseType == 'ad'){
        }else if($licenseType == 'safety'){
            $safety = StructuralSafetyCertificate::firstWhere('license_id', $license->id);
            $this->data['safety'] = $safety;
            self::getSafetyDesc($safety);
            $this->data['validity'] = LicenseValidation::where('license_id', $license->id)->orderBy('id', 'DESC')->first();
        }else if($licenseType == 'compatibility'){
            $this->data['compatibility'] = CompatibilityCertificate::firstWhere('license_id', $license->id);
            $this->data['validity'] = LicenseValidation::where('license_id', $license->id)->orderBy('id', 'DESC')->first();
        }else if($licenseType == 'completion'){
            $this->data['validity'] = LicenseValidation::where('license_id', $license->id)->orderBy('id', 'DESC')->first();
            $numberServices  = new NumberConversionService();

            if(is_null($this->data['validity'])){
                $numberDay = 0;
                $this->data['validity'] = new LicenseValidation(['created_at' => Carbon::now()]);
            }else $numberDay =  $this->data['validity']->created_at->format('d');

            $this->data['validity']->dayDesc = $numberServices->convertirNumeroEnLetras($numberDay);
        }else if($licenseType == 'break_pavement'){
            $this->data['order'] = Order::firstWhere('license_id', $license->id);
            $numberServices  = new NumberConversionService();
            $this->data['order']->totalDesc = $numberServices->convertirEurosEnLetras($this->data['order']->total);
        }
    }

    public function getTemplate(License $license, $pdfType)
    {
        $licenseType = $this->checkLicenseType->checkLicenseType($license->license_type_id);

        if ($pdfType) $this->template = 'licenses.'; //? license folder
        else $this->template = 'requests.'; //? requests folder

        if( $licenseType == 'construction')
        {  //?construction
            $this->template .= 'construction';
        }
        else if($licenseType == 'ad' || $licenseType == 'vehicle_ad'){
            $this->template .= 'ad';
        }
        else if($licenseType == 'safety'){
            $this->template .= 'structuralSafety';
        }
        else if($licenseType == 'compatibility'){
            $this->template .= 'compatibility';
        }
        else if($licenseType == 'completion'){
            $this->template .= 'completion';
        }
        else if($licenseType == 'break_pavement'){
            $this->template .= 'breackPaviment';
        }
    }

    public function getSafetyDesc(StructuralSafetyCertificate $safety)
    {
        switch ($safety->destino) {
                case 1:
                    $this->data['safety']->destino = 'Casa Habitación';
                    $this->data['safety']->carga = '190 km/m2';
                    break;
                case 2:
                    $this->data['safety']->destino = 'Departamentos';
                    $this->data['safety']->carga = '190 km/m2';
                    break;
                case 3:
                    $this->data['safety']->destino = 'Viviendas';
                    $this->data['safety']->carga = '190 km/m2';
                    break;
                case 4:
                    $this->data['safety']->destino = 'Dormitorios';
                    $this->data['safety']->carga = '190 km/m2';
                    break;
                case 5:
                    $this->data['safety']->destino = 'Cuartos de Hotel';
                    $this->data['safety']->carga = '190 km/m2';
                    break;
                case 6:
                    $this->data['safety']->destino = 'Internados de Escuela';
                    $this->data['safety']->carga = '190 km/m2';
                    break;
                case 7:
                    $this->data['safety']->destino = 'Cuarteles';
                    $this->data['safety']->carga = '190 km/m2';
                    break;
                case 8:
                    $this->data['safety']->destino = 'Cárceles';
                    $this->data['safety']->carga = '190 km/m2';
                    break;
                case 9:
                    $this->data['safety']->destino = 'Correccionales';
                    $this->data['safety']->carga = '190 km/m2';
                    break;
                case 10:
                    $this->data['safety']->destino = 'Hospitales y similares';
                    $this->data['safety']->carga = '190 km/m2';
                    break;
                case 11:
                    $this->data['safety']->destino = 'Oficinas';
                    $this->data['safety']->carga = '250 km/m2';
                    break;
                case 12:
                    $this->data['safety']->destino = 'Despachos';
                    $this->data['safety']->carga = '250 km/m2';
                    break;
                case 13:
                    $this->data['safety']->destino = 'Laboratorios';
                    $this->data['safety']->carga = '250 km/m2';
                    break;
                case 14:
                    $this->data['safety']->destino = 'Aulas';
                    $this->data['safety']->carga = '250 km/m2';
                    break;
                case 15:
                    $this->data['safety']->destino = 'Pasillos';
                    $this->data['safety']->carga = '350 km/m2';
                    break;
                case 16:
                    $this->data['safety']->destino = 'Escaleras';
                    $this->data['safety']->carga = '350 km/m2';
                    break;
                case 17:
                    $this->data['safety']->destino = 'Rampas';
                    $this->data['safety']->carga = '350 km/m2';
                    break;
                case 18:
                    $this->data['safety']->destino = 'Vestíbulos';
                    $this->data['safety']->carga = '350 km/m2';
                    break;
                case 19:
                    $this->data['safety']->destino = 'Pasajes de acceso libre al público';
                    $this->data['safety']->carga = '350 km/m2';
                    break;
                case 20:
                    $this->data['safety']->destino = 'Estadios';
                    $this->data['safety']->carga = '450 km/m2';
                    break;
                case 21:
                    $this->data['safety']->destino = 'Lugares de Reunión sin asientos individuales';
                    $this->data['safety']->carga = '450 km/m2';
                    break;
                case 22:
                    $this->data['safety']->destino = 'Bibliotecas';
                    $this->data['safety']->carga = '350 km/m2';
                    break;
                case 23:
                    $this->data['safety']->destino = 'Templos';
                    $this->data['safety']->carga = '350 km/m2';
                    break;
                case 24:
                    $this->data['safety']->destino = 'Cines';
                    $this->data['safety']->carga = '350 km/m2';
                    break;
                case 25:
                    $this->data['safety']->destino = 'Teatros';
                    $this->data['safety']->carga = '350 km/m2';
                    break;
                case 26:
                    $this->data['safety']->destino = 'Gimnasion';
                    $this->data['safety']->carga = '350 km/m2';
                    break;
                case 27:
                    $this->data['safety']->destino = 'Salones de baile';
                    $this->data['safety']->carga = '350 km/m2';
                    break;
                case 28:
                    $this->data['safety']->destino = 'Restaurantes';
                    $this->data['safety']->carga = '350 km/m2';
                    break;
                case 29:
                    $this->data['safety']->destino = 'Salas de juego y similares';
                    $this->data['safety']->carga = '350 km/m2';
                    break;
                case 30:
                    $this->data['safety']->destino = 'Comercios';
                    $this->data['safety']->carga = '350 km/m2';
                    break;
                case 31:
                    $this->data['safety']->destino = 'Fabricas';
                    $this->data['safety']->carga = '350 km/m2';
                    break;
                case 32:
                    $this->data['safety']->destino = 'Bodegas';
                    $this->data['safety']->carga = '350 km/m2';
                    break;
                case 33:
                    $this->data['safety']->destino = 'Azoteas con pendientes mayor a 5%';
                    $this->data['safety']->carga = '100 km/m2';
                    break;
                case 34:
                    $this->data['safety']->destino = 'Azoteas con pendientes no mayor a 5%, otras cubiertas cualquier pendiente';
                    $this->data['safety']->carga = '40 km/m2';
                    break;
                case 35:
                    $this->data['safety']->destino = 'Volados en vía pública, marquesinas, balcones y similares';
                    $this->data['safety']->carga = '300 km/m2';
                    break;
                case 36:
                    $this->data['safety']->destino = 'Garajes y Estacionamientso para vehículos';
                    $this->data['safety']->carga = '250 km/m2';
                    break;
                default:
                    $this->data['safety']->destino = 'Undefined';
                    $this->data['safety']->carga = 'Undefined';
                    break;
            }
    }

    public function getDepDir(License $license)
    {
        $dirDep = LicenseType::firstWhere('id',$license->license_type_id)
            ->with('department.users')->get();

        return $dirDep[0]->department->users->map(function($usr){
            if ($usr->getRoleNames()[0] =='directorDpt') return $usr;
        })->reject(function ($value) {
            return $value == null;
        });
    }
}
