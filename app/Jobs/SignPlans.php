<?php

namespace App\Jobs;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;

class SignPlans implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected $license;
    protected $user;

    public function __construct($license, $user)
    {
        $this->license = $license;
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $license = $this->license;
        self::getPlans($license, $this->user);
    }

    public function getPlans($license, $user)
    {
        $plans = $license->requirements()->get();
        $plans = $plans->map(function ($plan){
            if (($plan->requirement->es_plano || $plan->requirement->id == 17) &&
                (!is_null($plan->archivo_nombre)) &&
                !$plan->firmado) { //17 bitacora
                return $plan;
            }
        })->reject(function ($value) { return $value == null; });

        // $user = User::with('credentials')->find($user->id);
        $user = User::with('credentials')->find(19);
        logger($user);

        $plans->map(function ($plan) use ($license, $user){
            // logger($license->id);
            // logger($plan->archivo_nombre);
            $file  = file_get_contents(storage_path("app/public/solicitantes/{$license->user_id}/licencias/{$license->id}/requisitos/{$plan->archivo_nombre}"));
            $response = Http::acceptJson()->attach(
                'document', $file, 'pdf-licencia.pdf'
            )->post('https://efirma.capitaldezacatecas.gob.mx/api/v1/initialize', [
                'signers_number' => 1,
            ]);

            $signed = (json_decode($response));

            // logger("init");
            // logger($response);
            // logger($signed->process_id);
            Http::acceptJson()
            ->post('https://efirma.capitaldezacatecas.gob.mx/api/v1/massive', [
                'username' => $user->credentials->username,
                'password' => $user->credentials->password,
                'process_id' =>  $signed->process_id,
            ]);
            // logger("massive");
            // logger($response);
            $response = Http::acceptJson()
            ->post('https://efirma.capitaldezacatecas.gob.mx/api/v1/finalize', [
                'process_id' =>  $signed->process_id,
            ]);
            $file_URL = json_decode($response);
            // logger('finalize');
            // logger($response);
            exec("chonw -R root:root /var/www/permisos.capitaldezacatecas.gob.mx/api/storage/app/public/solicitantes/{$license->user_id}/licencias/{$license->id}/");
            exec("chmod -R 0777 /var/www/permisos.capitaldezacatecas.gob.mx/api/storage/app/public/solicitantes/{$license->user_id}/licencias/{$license->id}/");

            if(copy(
                $file_URL->file,
                storage_path("app/public/solicitantes/{$license->user_id}/licencias/{$license->id}/requisitos/{$plan->archivo_nombre}")
            )){
                $plan->firmado = true;
                $plan->save();
            }
        });
    }
}
