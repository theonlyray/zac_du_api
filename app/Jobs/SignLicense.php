<?php

namespace App\Jobs;

use App\Models\ApplicantData;
use App\Models\ConstructionBackground;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\License;
use App\Models\LicenseType;
use App\Models\LicenseValidation;
use App\Models\Order;
use App\Models\StructuralSafetyCertificate;
use App\Models\User;
use App\Services\CheckLicenseType;
use App\Services\NumberConversionService;
use Carbon\Carbon;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class SignLicense implements ShouldQueue
{
    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */

    protected $license;
    protected $user;
    protected $checkLicenseType;
    protected $data;
    protected $template;

    public function __construct($license, $user)
    {
        $this->license = $license;
        $this->user = $user;
        $this->checkLicenseType = new CheckLicenseType();
        $this->data = array();
        $this->template = (string) NULL;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        return self::signLicense($this->license, $this->user);
    }

    public function signLicense(License $license, $user)
    {
        $user = User::with('credentials')->find($user->id);

        $file  = file_get_contents(storage_path("app/public/solicitantes/{$license->user_id}/licencias/{$license->id}/{$license->folio}.pdf"));

        $response = Http::acceptJson()->attach(
            'document', $file, 'pdf-licencia.pdf'
        )->post('https://efirma.capitaldezacatecas.gob.mx/api/v1/initialize', [
            'signers_number' => 1,
        ]);

        $signed = (json_decode($response));

        Http::acceptJson()
        ->post('https://efirma.capitaldezacatecas.gob.mx/api/v1/massive', [
            'username' => $user->credentials->username,
            'password' => $user->credentials->password,
            'process_id' =>  $signed->process_id,
        ]);

        $response = Http::acceptJson()
        ->post('https://efirma.capitaldezacatecas.gob.mx/api/v1/finalize', [
            'process_id' =>  $signed->process_id,
        ]);

        $file_URL = json_decode($response);
        // logger($file_URL->file);
        exec("chmod -R 0777 /var/www/permisos.capitaldezacatecas.gob.mx/api/storage/app/public/solicitantes/{$license->user_id}/licencias/{$license->id}/");

        if (copy(
            $file_URL->file,
            storage_path("app/public/solicitantes/{$license->user_id}/licencias/{$license->id}/{$license->folio}.pdf"))){
                $license->firmada = true;
                $license->save();
            }
    }
}
