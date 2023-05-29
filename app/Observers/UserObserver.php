<?php

namespace App\Observers;

use App\Models\User;
use Illuminate\Support\Facades\Storage;

class UserObserver
{
    public function deleting(User $user): void
    {
        if (Storage::disk('public')->exists("users/{$user->id}.jpg")) {
            Storage::disk('public')->delete("users/{$user->id}.jpg");
        }
        $user->tokens()->delete();
    }
}
