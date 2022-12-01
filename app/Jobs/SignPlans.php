<?php

namespace App\Jobs;

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

    public function __construct($license)
    {
        $this->license = $license;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $license = $this->license;
        self::getPlans($license);
    }

    public function getPlans($license)
    {
        $plans = $license->requirements()->get();
        $plans = $plans->map(function ($plan){
            if ($plan->requirement->es_plano || $plan->requirement->id == 17 && (!is_null($plan->archivo_nombre))) { //17 bitacora
                return $plan;
            }
        })->reject(function ($value) { return $value == null; });

        $plans->map(function ($plan) use ($license){

            $file  = file_get_contents(storage_path("app/public/solicitantes/{$license->user_id}/licencias/{$license->id}/requisitos/{$plan->archivo_nombre}"));
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
                storage_path("app/public/solicitantes/{$license->user_id}/licencias/{$license->id}/requisitos/{$plan->archivo_nombre}")
            );
        });
    }
}
