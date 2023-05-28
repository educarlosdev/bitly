<?php

namespace App\Models;

use App\Traits\HasPrimaryKeyUuid;
use App\Traits\SerializeDate;
use Carbon\Carbon;
use hisorange\BrowserDetect\Facade as Browser;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Hit extends Model
{
    use HasFactory, HasPrimaryKeyUuid, SerializeDate;

    protected $appends = [
        'created_formatted',
        'parse_user_agent',
    ];

    public function link(): BelongsTo
    {
        return $this->belongsTo(Link::class);
    }

    public function createdFormatted(): Attribute
    {
        return Attribute::make(
            get: function ($value, $attributes) {
                $created_at = new Carbon($attributes['created_at']);

                return "{$created_at->diffForHumans(now(), true)}";
            }
        );
    }

    protected function parseUserAgent(): Attribute
    {
        return Attribute::make(
            get: fn ($value, $attributes) => Browser::parse($attributes['user_agent']),
        );
    }
}
