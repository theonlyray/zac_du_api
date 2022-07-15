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

        if ($user->can('license.validateEntry') || $user->can('license.validateFirstReview') ||
            $user->can('license.validateSecondReview') || $user->can('license.validateThirdReview')) {
            DB::beginTransaction();

            try {
                $validition = new LicenseValidation(['user_id' => $user->id, 'descripcion' => $license->estatus]);
                $license->validations()->save($validition);

                $observations = LicenseObservation::where('created_at', '<=', Carbon::now())->get(); //get observations befo current validation

                $observations = $observations->map(function ($observation){
                    $observation->solventada = true; //?if theres a new validation old observations must be solved
                     return $observation->save();
                });
            } catch (\Throwable $th) {
                //throw $th;
                logger($th);
                DB::rollBack();
                return 'Error al generar validación '. $th->getMessage();
            }
            DB::commit();
        }else return 'No tienes permisos para realizar validar esta étapa.';

        return true;
    }
}
