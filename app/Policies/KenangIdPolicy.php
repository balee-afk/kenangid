<?php

namespace App\Policies;

use App\Models\KenangId;
use App\Models\User;

class KenangIdPolicy
{
    public function update(User $user, KenangId $kenangId)
    {
        return $user->id === $kenangId->user_id;
    }

    public function delete(User $user, KenangId $kenangId)
    {
        return $user->id === $kenangId->user_id;
    }
}
