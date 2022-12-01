<?php

namespace App\Listeners;

use App\Events\ApiOPQueried;
use App\Models\DepartmentUser;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Http;

class APIPOAuthentication
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
     * @param  \App\Events\ApiOPQueried  $event
     * @return void
     */
    public function handle(ApiOPQueried $event)
    {
        $user = $event->user;

        $response = Http::acceptJson()
            ->post('http://10.220.107.112/api/login', [
                'name' => 'pruebaapi',
                'password' => 'pruebaapi'
            ]);

        abort_if(!$response->successful(),500,'Error de autenticacion (API), intentelo más tarde.');
        $response = (json_decode($response));

        if (!is_null($user) && $user->hasRole(['directorDpt', 'subDirectorDpt', 'jefeUnidadDpt', 'colaboradorDpt'])){
            $depData = DepartmentUser::firstWhere('user_id', $user->id);
            $depData->fill(['api_op_token' =>$response->token]);
            $depData->save();

            return;
        }
        return $response->token;
    }
}
