<?php

namespace App\Models;

use App\Traits\HasPrimaryKeyUuid;
use App\Traits\SerializeDate;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Hit extends Model
{
    use HasFactory, HasPrimaryKeyUuid, SerializeDate;

    public function link(): BelongsTo
    {
        return $this->belongsTo(Link::class);
    }
}
