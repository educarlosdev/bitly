<?php

namespace App\Models;

use App\Traits\HasPrimaryKeyUuid;
use App\Traits\SerializeDate;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Link extends Model
{
    use HasFactory, HasPrimaryKeyUuid, SerializeDate;

    protected $appends = [
        'slug_url',
    ];

    protected $fillable = [
        'url',
        'slug',
        'user_id',
    ];

    public function scopeUserAuth(Builder $builder, string $user_id): void
    {
        $builder->where('user_id', $user_id);
    }

    protected function slugUrl(): Attribute
    {
        return Attribute::make(
            get: fn ($value, $attributes) => url($attributes['slug']),
        );
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function hits(): HasMany
    {
        return $this->hasMany(Hit::class);
    }
}
