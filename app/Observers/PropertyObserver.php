<?php

namespace App\Observers;

use App\Models\Property;

class PropertyObserver
{
    public function creating(Property $property)
    {
        if (! \App::runningInConsole()) {
            // $property->user_id = auth()->user()->id;
            gc_collect_cycles();
        }
    }
}
