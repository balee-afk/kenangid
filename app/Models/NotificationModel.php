<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotificationModel extends Model
{
    protected $table = 'notifications'; // Nama tabel di database

    public function users()
    {
        return $this->belongsToMany(User::class, 'notification_user', 'notification_id', 'user_id')
                    ->withPivot('is_read')
                    ->withTimestamps();
    }
}
