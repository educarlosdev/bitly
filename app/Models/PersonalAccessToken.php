<?php

namespace App\Models;

use App\Traits\HasPrimaryKeyUuid;
use App\Traits\SerializeDate;
use Laravel\Sanctum\PersonalAccessToken as SanctumPersonalAccessToken;

class PersonalAccessToken extends SanctumPersonalAccessToken
{
    use HasPrimaryKeyUuid, SerializeDate;
}
