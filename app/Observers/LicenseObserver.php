<?php

namespace App\Observers;

use App\Models\License;
use Carbon\Carbon;

class LicenseObserver
{
    public function creating(License $license)
    {
        // if (! \App::runningInConsole()) {
        $license->user_id = auth()->user()->id;
        gc_collect_cycles();
        // }
    }

    public function created(License $license)
    {
        $year = Carbon::now()->year;
        $counter = License::where('estatus','<>',0)->count('id');
        $acronym = self::setFolio($license);

        // $license->id
        if ($license->license_type_id == 6){ $license->folio  = "PRO-{$license->id}-{$year}"; }
        elseif ($license->license_type_id == 23){ $license->folio  = "TER-{$license->id}-{$year}"; }
        else{ $license->folio  = "{$acronym}-{$license->id}-{$year}"; }

        if ($license->license_type_id == 22) {
            $license->liberada = false;
        }

        $license->saveQuietly();
        gc_collect_cycles();
    }

    public function setFolio(License $license)
    {
        switch ($license->license_type_id) {
            case 1: return 'LCME'; break;
            case 2: return 'LCMA'; break;
            case 3: return 'LPE'; break;
            case 4: return 'PB'; break;
            case 5: return 'PTM'; break;
            case 6: return 'POR'; break;
            case 7: return 'NO'; break;
            case 8: return 'PITE'; break;
            case 9: return 'PIAT'; break;
            case 10: return 'PIESC'; break;
            case 11: return 'PIESG'; break;
            case 12: return 'CSU'; break;
            case 13: return 'CA'; break;
            case 14: return 'CSE'; break;
            case 15: return 'REG'; break;
            case 16: return 'CCU'; break;
            case 17: return 'AAF'; break;
            case 18: return 'ATE'; break;
            case 19: return 'ATA'; break;
            case 20: return 'AV'; break;
            case 21: return 'SEA'; break;
            case 22: return 'ASDF'; break;
            case 23: return 'TER'; break;
            case 24: return 'PRP'; break;
            case 25: return 'PTD'; break;
            case 26: return 'LCTME'; break;
            case 27: return 'LCTMA'; break;
            case 28: return 'PC'; break;
            case 29: return 'A'; break;
            default: return 'undef'; break;
        }
    }
}
