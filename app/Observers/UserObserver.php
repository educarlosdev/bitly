<?php

namespace App\Observers;

use App\Models\User;

class UserObserver
{
    public function deleting(User $user): void
    {
        $user->tokens()->delete();
    }
}
