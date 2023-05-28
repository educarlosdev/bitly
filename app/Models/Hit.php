<?php

namespace App\Models;

use App\Traits\HasPrimaryKeyUuid;
use App\Traits\SerializeDate;
use hisorange\BrowserDetect\Facade as Browser;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Hit extends Model
{
    use HasFactory, HasPrimaryKeyUuid, SerializeDate;

    protected $appends = [
        'parse_user_agent',
    ];

    public function link(): BelongsTo
    {
        return $this->belongsTo(Link::class);
    }

    protected function parseUserAgent(): Attribute
    {
        return Attribute::make(
            get: fn ($value, $attributes) => collect(Browser::parse($attributes['user_agent']))->toArray(),
        );
    }
}
