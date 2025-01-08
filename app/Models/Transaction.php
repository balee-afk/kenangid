<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    // Nama tabel
    protected $table = 'transactions';

    // Kolom yang dapat diisi
    protected $fillable = [
        'user_id',
        'transaction_type',
        'amount',
        'proof', //foto bukti
        'status', 
        'transaction_date',
    ];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
