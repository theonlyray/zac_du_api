<?php

namespace App\Http\Controllers\Pdfs;

use App\Events\GenerateLicense;
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

    public function __construct()
    {

    }

    public function preview(License $license)//?preview license
    {
        //?generate a new update license
        event(new GenerateLicense($license));
        return response()->download(
            storage_path("app/public/solicitantes/{$license->user_id}/licencias/{$license->id}/{$license->folio}.pdf"),
            "{$license->folio}.pdf"
        );
    }

    public function request(License $license) //? request pdf (solicitud)
    {
        // self::getData($license);
        // self::getTemplate($license, false);

        // $pdf = PDF::loadView($this->template, $this->data)->setPaper('letter', 'portrait');

        // return $pdf->stream();
    }

    public function license(License $license)//?download license signed
    {
        logger($license->liberada);
        if ($license->liberada) {
            return response()->download(
                storage_path("app/public/solicitantes/{$license->user_id}/licencias/{$license->id}/{$license->folio}.pdf"),
                "{$license->folio}.pdf"
            );
        }

        $license->load('owner');

        $pdf = PDF::loadView('licenses.forbbiden', ['license'=>$license])->setPaper('letter', 'portrait');

        return $pdf->stream();
    }
}
