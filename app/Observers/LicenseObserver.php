<?php

namespace App\Observers;

use App\Models\License;
use Carbon\Carbon;

class LicenseObserver
{
    public function creating(License $license)
    {
        if (! \App::runningInConsole()) {
            $license->user_id = auth()->user()->id;
            gc_collect_cycles();
        }
    }

    public function updating(License $license)
    {
        $year = Carbon::now()->year;
        if ($license->estatus == 'Docs. Cargados' || $license->estatus == 'Cancelado' ||
            $license->estatus == 'Rechazado') $license->folio  = "TODEF-00XX-{$license->id}-{$year}";
    }
}
