<?php

namespace App\Observers;

use App\Models\Link;
use Illuminate\Support\Str;

class LinkObserver
{
    public function creating(Link $link): void
    {
        $link->user_id = $link->user_id ?? auth()->id();
        $link->slug = $link->slug ? str($link->slug)->slug() : str(Str::random(rand(6, 8)))->slug();
    }
}
