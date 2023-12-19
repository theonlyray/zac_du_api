<?php

namespace App\Listeners;

use App\Events\GenerateLicense;
use App\Models\ApplicantData;
use App\Models\ConstructionBackground;
use App\Models\License;
use App\Models\LicenseValidation;
use App\Models\Order;
use App\Models\StructuralSafetyCertificate;
use App\Models\User;
use App\Services\CheckLicenseType;
use App\Services\NumberConversionService;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Log\Logger;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Storage;

class CreateLicense
{
    /**
     * Create the event listener.
     *
     * @return void
     */

    protected $checkLicenseType;
    protected $data;
    protected $template;
    protected $numberServices;
    protected $meses;

    public function __construct()
    {
        $this->checkLicenseType = new CheckLicenseType();
        $this->numberServices  = new NumberConversionService();
        $this->meses = array("enero", "febrero", "marzo", "abril", "mayo", "junio", "julio",
                   "agosto", "septiembre", "octubre", "noviembre", "diciembre");
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\GenerateLicense  $event
     * @return void
     */
    public function handle(GenerateLicense $event)
    {
        $license = $event->license;

        self::getData($license);
        self::getTemplate($license, true);

        try {
            if ($license->license_type_id == 16) { //?compatibility
                $pdf = PDF::loadView($this->template, $this->data)->setPaper('legal', 'portrait');
            }else{
                $pdf = PDF::loadView($this->template, $this->data)->setPaper('letter', 'portrait');
            }
            Storage::put("public/solicitantes/{$license->user_id}/licencias/{$license->id}/{$license->folio}.pdf",$pdf->output());
        } catch (\Throwable $th) {
            logger($th->getMessage());
            //throw $th;
        }
    }

    public function getData(License $license)
    {
        $licenseType = $this->checkLicenseType->checkLicenseType($license->license_type_id);

        $license->load(['licenseType.department.users.roles',
            'applicant', 'applicant.applicantData','property',
            'backgrounds', 'construction', 'owner',
            'validity', 'requirements', 'ads',
            'validations', 'observations',
            'order', 'order.duties', 'selfBuild',
            'sfd', 'lots'
        ]);

        $users = $license->licenseType->department->users;
        //?find user with role roledirectorDpt in users collection
        $dirDep = $users->filter(function ($user) {
            return $user->hasRole('directorDpt');
        })->first();

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
            'dirDep'        => $dirDep,
        ];

        self::settingValidity($license);

        if( $licenseType == 'construction'){  //?construction
            self::settingConstruction($license);
        }
        elseif($licenseType == 'vehicle_ad' || $licenseType == 'ad'){
            $this->data['adD'] = $this->numberServices->convertirNumeroEnLetras($license->ads()->count());
        }
        elseif($licenseType == 'safety'){
            $safety = StructuralSafetyCertificate::firstWhere('license_id', $license->id);
            $this->data['safety'] = $safety;
            self::getSafetyDesc($safety);
        }
        elseif($licenseType == 'completion' || $licenseType == 'urban_services' || $licenseType == 'self-build'){
            if(is_null($this->data['validity'])){
                $numberDay = 99;
                $this->data['validity'] = new LicenseValidation(['created_at' => Carbon::now()]);
            }else{ $numberDay =  $this->data['validity']->created_at->format('d'); }
            $this->data['validity']->dayDesc = $this->numberServices->convertirNumeroEnLetras($numberDay);

            if ($licenseType == 'self-build') {
                $numberDay =  $this->data['license']->fecha_actualizacion->format('d');
                $this->data['validity']->dayDesc = $this->numberServices->convertirNumeroEnLetras($numberDay);

                if (is_null($license->backgrounds[0]->physical_prior_license_id)) {
                    $lic = License::find($license->backgrounds[0]->prior_license_id);
                    $this->data['priorLicence'] = $lic;
                }else{
                    $this->data['priorLicence'] = $license->backgrounds[0];
                }
            }
        }
        elseif($licenseType == 'break_pavement'){
            $this->data['order'] = Order::firstWhere('license_id', $license->id) ?? new Order();
            $numberServices  = new NumberConversionService();
            $this->data['order']->totalDesc = $numberServices->convertirEurosEnLetras($this->data['order']->total ?? 0);
        }
        elseif($licenseType == 'compatibility') {
            $this->data['compatibility'] = $license->compatibilityCertificate;
        }
        elseif($licenseType == 'sfd') {
            $actvArray = $license->SFD()->get()->pluck('actividad')->toArray();
            $this->data['actividad'] = implode(', ', array_unique(($actvArray)));
        }
    }

    public function getTemplate(License $license)
    {
        $licenseType = $this->checkLicenseType->checkLicenseType($license->license_type_id);

        if( $licenseType == 'construction'){  //?construction
            $this->template = 'licenses.construction';
        }
        else if($licenseType == 'ad' || $licenseType == 'vehicle_ad'){
            $this->template = 'licenses.ads';
        }
        else if($licenseType == 'safety'){
            $this->template = 'licenses.structuralSafety';
        }
        else if($licenseType == 'completion'){
            $this->template = 'licenses.completion';
        }
        else if($licenseType == 'break_pavement'){
            $this->template = 'licenses.breackPaviment';
        }
        elseif ($licenseType == 'oficial_number') {
            $this->template = 'licenses.officialNo';
        }
        elseif ($licenseType == 'alignment') {
            $this->template = 'licenses.alignment';
        }
        elseif ($licenseType == 'urban_services') {
            $this->template = 'licenses.urbanServices';
        }
        elseif ($licenseType == 'self-build') {
            $this->template = 'licenses.selfBuild';
        }
        elseif ($licenseType == 'compatibility') {
            $this->template = 'licenses.compatibility';
        }
        elseif ($licenseType == 'sfd') {
            $this->template = 'licenses.sfd';
        }
    }

    /**
     * @param License $license
     * add the validity date to the data array
     * @return void
     */
    private function settingValidity(License $license)
    {
        $validity = LicenseValidation::where('license_id', $license->id)->orderBy('id', 'DESC')->first();
        if (!is_null($validity)) {
            $this->data['validity'] = $validity;
            $this->data['validity']->dayDesc =
                $this->numberServices->convertirNumeroEnLetras($this->data['validity']->created_at->format('d'));
            $mes = $this->meses[$this->data['validity']->created_at->format('m')-1];
            $this->data['validity_date'] = $this->data['validity']->created_at->format('d') . ' de ' . $mes .
                ' de ' . $this->data['validity']->created_at->format('Y');
            $this->data['validity_month'] = $mes;
            $this->data['validity_year'] = $this->data['validity']->created_at->format('Y');
        }else {
            $this->data['validity'] = new LicenseValidation(['created_at' => Carbon::now()]);
            //? if the license is not validated yet, we use the date of the last update
            $mes = $this->meses[$license->fecha_actualizacion->format('m')-1];
            $this->data['validity_date'] = $license->fecha_actualizacion->format('d') . ' de ' . $mes . ' de ' .
                $license->fecha_actualizacion->format('Y') . ' {VISTA PREVIA}';
            $this->data['validity_month'] = $mes;
            $this->data['validity_year'] = $license->fecha_actualizacion->format('Y');
        }
    }

    /**
     * @param License $license
     * add the construction data to the data array
     */
    private function settingConstruction(License $license)
    {
        $backgrounds = ConstructionBackground::where('current_license_id',$license->id)
            ->with('priorLicense')->get();

        $priorLicenseIds = $backgrounds->pluck('prior_license_id')->toArray();
        $priorLicenseIds = collect($priorLicenseIds)->filter(function ($value, $key) {
            return $value != null;
        });
        $priorLicenses = License::whereIn('id',$priorLicenseIds)->get(['folio','fecha_actualizacion']);

        $this->data['backgrounds']      = $backgrounds;
        $this->data['priorLicenses']    = $priorLicenses;

        // setting validity dates
        if ($license->license_type_id != 14) {//?sefty
            $this->data['validity']->auth_date = $license->validity->fecha_autorizacion->format('d') . ' de ' .
            $this->meses[$license->validity->fecha_autorizacion->format('m')-1] . ' de ' .
            $license->validity->fecha_autorizacion->format('Y');
            $this->data['validity']->end_date = $license->validity->fecha_fin_vigencia->format('d') . ' de ' .
            $this->meses[$license->validity->fecha_fin_vigencia->format('m')-1] . ' de ' .
            $license->validity->fecha_fin_vigencia->format('Y');
        }
    }

    public function getSafetyDesc(StructuralSafetyCertificate $safety)
    {
        switch ($safety->destino) {
                case 1:
                    $this->data['safety']->destino_d = 'Casa Habitación';
                    $this->data['safety']->carga = '190 km/m2';
                    break;
                case 2:
                    $this->data['safety']->destino_d = 'Departamentos';
                    $this->data['safety']->carga = '190 km/m2';
                    break;
                case 3:
                    $this->data['safety']->destino_d = 'Viviendas';
                    $this->data['safety']->carga = '190 km/m2';
                    break;
                case 4:
                    $this->data['safety']->destino_d = 'Dormitorios';
                    $this->data['safety']->carga = '190 km/m2';
                    break;
                case 5:
                    $this->data['safety']->destino_d = 'Cuartos de Hotel';
                    $this->data['safety']->carga = '190 km/m2';
                    break;
                case 6:
                    $this->data['safety']->destino_d = 'Internados de Escuela';
                    $this->data['safety']->carga = '190 km/m2';
                    break;
                case 7:
                    $this->data['safety']->destino_d = 'Cuarteles';
                    $this->data['safety']->carga = '190 km/m2';
                    break;
                case 8:
                    $this->data['safety']->destino_d = 'Cárceles';
                    $this->data['safety']->carga = '190 km/m2';
                    break;
                case 9:
                    $this->data['safety']->destino_d = 'Correccionales';
                    $this->data['safety']->carga = '190 km/m2';
                    break;
                case 10:
                    $this->data['safety']->destino_d = 'Hospitales y similares';
                    $this->data['safety']->carga = '190 km/m2';
                    break;
                case 11:
                    $this->data['safety']->destino_d = 'Oficinas';
                    $this->data['safety']->carga = '250 km/m2';
                    break;
                case 12:
                    $this->data['safety']->destino_d = 'Despachos';
                    $this->data['safety']->carga = '250 km/m2';
                    break;
                case 13:
                    $this->data['safety']->destino_d = 'Laboratorios';
                    $this->data['safety']->carga = '250 km/m2';
                    break;
                case 14:
                    $this->data['safety']->destino_d = 'Aulas';
                    $this->data['safety']->carga = '250 km/m2';
                    break;
                case 15:
                    $this->data['safety']->destino_d = 'Pasillos';
                    $this->data['safety']->carga = '350 km/m2';
                    break;
                case 16:
                    $this->data['safety']->destino_d = 'Escaleras';
                    $this->data['safety']->carga = '350 km/m2';
                    break;
                case 17:
                    $this->data['safety']->destino_d = 'Rampas';
                    $this->data['safety']->carga = '350 km/m2';
                    break;
                case 18:
                    $this->data['safety']->destino_d = 'Vestíbulos';
                    $this->data['safety']->carga = '350 km/m2';
                    break;
                case 19:
                    $this->data['safety']->destino_d = 'Pasajes de acceso libre al público';
                    $this->data['safety']->carga = '350 km/m2';
                    break;
                case 20:
                    $this->data['safety']->destino_d = 'Estadios';
                    $this->data['safety']->carga = '450 km/m2';
                    break;
                case 21:
                    $this->data['safety']->destino_d = 'Lugares de Reunión sin asientos individuales';
                    $this->data['safety']->carga = '450 km/m2';
                    break;
                case 22:
                    $this->data['safety']->destino_d = 'Bibliotecas';
                    $this->data['safety']->carga = '350 km/m2';
                    break;
                case 23:
                    $this->data['safety']->destino_d = 'Templos';
                    $this->data['safety']->carga = '350 km/m2';
                    break;
                case 24:
                    $this->data['safety']->destino_d = 'Cines';
                    $this->data['safety']->carga = '350 km/m2';
                    break;
                case 25:
                    $this->data['safety']->destino_d = 'Teatros';
                    $this->data['safety']->carga = '350 km/m2';
                    break;
                case 26:
                    $this->data['safety']->destino_d = 'Gimnasion';
                    $this->data['safety']->carga = '350 km/m2';
                    break;
                case 27:
                    $this->data['safety']->destino_d = 'Salones de baile';
                    $this->data['safety']->carga = '350 km/m2';
                    break;
                case 28:
                    $this->data['safety']->destino_d = 'Restaurantes';
                    $this->data['safety']->carga = '350 km/m2';
                    break;
                case 29:
                    $this->data['safety']->destino_d = 'Salas de juego y similares';
                    $this->data['safety']->carga = '350 km/m2';
                    break;
                case 30:
                    $this->data['safety']->destino_d = 'Comercios';
                    $this->data['safety']->carga = '350 km/m2';
                    break;
                case 31:
                    $this->data['safety']->destino_d = 'Fabricas';
                    $this->data['safety']->carga = '350 km/m2';
                    break;
                case 32:
                    $this->data['safety']->destino_d = 'Bodegas';
                    $this->data['safety']->carga = '350 km/m2';
                    break;
                case 33:
                    $this->data['safety']->destino_d = 'Azoteas con pendientes mayor a 5%';
                    $this->data['safety']->carga = '100 km/m2';
                    break;
                case 34:
                    $this->data['safety']->destino_d = 'Azoteas con pendientes no mayor a 5%, otras cubiertas cualquier pendiente';
                    $this->data['safety']->carga = '40 km/m2';
                    break;
                case 35:
                    $this->data['safety']->destino_d = 'Volados en vía pública, marquesinas, balcones y similares';
                    $this->data['safety']->carga = '300 km/m2';
                    break;
                case 36:
                    $this->data['safety']->destino_d = 'Garajes y Estacionamientso para vehículos';
                    $this->data['safety']->carga = '250 km/m2';
                    break;
                default:
                    $this->data['safety']->destino_d = 'Undefined';
                    $this->data['safety']->carga = 'Undefined';
                    break;
            }
    }
}
