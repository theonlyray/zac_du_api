<?php

namespace App\Http\Controllers\Pdfs;

use App\Http\Controllers\Controller;
use App\Models\ApplicantData;
use App\Models\ConstructionBackground;
use App\Models\Department;
use App\Models\License;
use App\Models\User;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class PdfController extends Controller
{
    public function __construct()
    {
        $this->data = [];
        $this->template = '';
    }

    public function pdf_solicitud($tipo){
        $pdf = PDF::loadView('solicitudes.basic_solicitud');
        return $pdf->stream();
      }

    public function pdf_licencia(License $license){
        self::getDataTemplate($license);
        $pdf = PDF::loadView($this->template, $this->data)->setPaper('letter', 'portrait');
        // $pdf = Pdf::loadView('pdfs.pdf-licencia', compact('registro'))->setPaper('letter', 'portrait');
        $file = $pdf->output();

        //todo this must be moved to payment controller
        $response = Http::acceptJson()->attach(
            'document', $file, 'pdf-licencia.pdf'
        )->post('http://10.220.107.111/api/v1/initialize', [
            'signers_number' => 1,
        ]);

        $signed = (json_decode($response));

        $response = Http::acceptJson()
        ->post('http://10.220.107.111/api/v1/massive', [
            'username' => 'MIQS690515I74',
            'password' => 'WmtmpINMaU',
            'process_id' =>  $signed->process_id,
        ]);

        $response = Http::acceptJson()
        ->post('http://10.220.107.111/api/v1/finalize', [
            'process_id' =>  $signed->process_id,
        ]);
        $file_URL = json_decode($response);

        copy(
            $file_URL->file,
            storage_path("app/public/solicitantes/{$license->user_id}/licencias/{$license->id}/{$license->folio}.pdf"));
        // ////
        // self::getDataTemplate($license);
        // $pdf = PDF::loadView($this->template, $this->data)->setPaper('letter', 'portrait');
        // Storage::put("public/solicitantes/{$license->user_id}/licencias/{$license->id}/{$license->folio}.pdf",$pdf->output());
        // return $pdf->stream();
        return response()->download(
            storage_path("app/public/solicitantes/{$license->user_id}/licencias/{$license->id}/{$license->folio}.pdf"),
            "{$license->folio}.pdf"
        );
    }

    public function getDataTemplate(License $license)
    {
        // $jefeSDUMA  = User::role('jefeSDUMA')->get();
        // $department = Department::firstWhere('id', $license->license_type_id)->get();
        // $jefeDir    =
        // $dirs = [];
        // logger($applicant);
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

        $this->data = [
            'license'   => $license,
            'applicant'   => $applicant[0],
            'applicantData'   => $applicantData[0],
        ];
        // logger($applicant);

        if( $license->license_type_id >= 1 && $license->license_type_id <= 6 ||
            ($license->license_type_id >= 8 && $license->license_type_id <= 11) ||
            ($license->license_type_id == 15) ||
            ($license->license_type_id >= 24 && $license->license_type_id <= 28)
        ){  //?construction
            $backgrounds = ConstructionBackground::where('current_license_id',$license->id)
                ->with('priorLicense')->get();

            $priorLicenseIds = $backgrounds->pluck('prior_license_id')->toArray();
            $priorLicenseIds = collect($priorLicenseIds)->filter(function ($value, $key) {
                return $value != null;
            });
            $priorLicenses = License::whereIn('id',$priorLicenseIds)->get(['folio','fecha_actualizacion']);

            $this->data['backgrounds']      = $backgrounds;
            $this->data['priorLicenses']    = $priorLicenses;

            $this->template = 'licenses.basic_licencia';

        }
        else if($license->license_type_id >= 17 && $license->license_type_id <= 20){
            $this->template = 'licenses.ads';
        }
        logger($this->template);

    }
}
