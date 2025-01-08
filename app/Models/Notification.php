<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'admin_id',
        'user_id',
        'title',
        'message',
        'is_read',
    ];

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'notification_user')
                    ->withPivot('is_read')
                    ->withTimestamps();
    }
    
    
}
