<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KenangId extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'user_id',
        'media',
        'media_size',
        'caption',
        'type',
    ];

    protected $keyType = 'string';

    public $incrementing = false;

    // KenangId.php
public function user()
{
    return $this->belongsTo(User::class);
}

}
