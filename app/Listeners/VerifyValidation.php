<?php

namespace App\Listeners;

use App\Events\RequestValidated;
use App\Models\LicenseObservation;
use App\Models\LicenseValidation;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\DB;

class VerifyValidation
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\RequestValidated  $event
     * @return void
     */
    public function handle(RequestValidated $event)
    {
        $user       = $event->user;
        $license    = $event->license;

        $response = true;
        foreach ($license->requirements as $key => $requirement) {
            if ($requirement->requirement->obligatorio &&
                ($requirement->estatus != 'Doc. cargado' &&
                $requirement->estatus != 'Doc. corregido'&&
                $requirement->estatus != 'Doc. Validado')
                ) {//todo check why dont return boolean values
                return 'false';
            }
        }

        return 'true';
    }
}
