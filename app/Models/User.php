<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Traits\HasPrimaryKeyUuid;
use App\Traits\SerializeDate;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasPrimaryKeyUuid, SerializeDate;

    protected $appends = [
        'avatar_url',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function avatarUrl(): Attribute
    {
        return Attribute::make(
            get: fn ($value, $attributes) => Storage::disk('public')->exists("users/{$attributes['id']}.jpg")
                ? Storage::disk('public')->url("users/{$attributes['id']}.jpg?x={$attributes['updated_at']}")
                : null,
        );
    }

    public function links(): HasMany
    {
        return $this->hasMany(Link::class);
    }
}
