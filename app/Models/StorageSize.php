<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class StorageSize extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'current_size',
        'purchase_date',
        'expiry_date',
    ];

    /**
     * Check if the storage is active.
     * Returns true if the current date is before or equal to expiry_date.
     */
    public function isActive()
    {
        return Carbon::now()->lessThanOrEqualTo(Carbon::parse($this->expiry_date));
    }

    /**
     * Calculate remaining size (if applicable).
     * Assuming that current size is the total used, and you want to check limits.
     * If no max_size, handle with a fixed limit or logic.
     */
    /**
 * Get remaining size of the storage.
 */
public function remainingSize($maxSize)
{
    return max(0, $maxSize - $this->current_size);
}

/**
 * Check if the storage is expired.
 */
public function isExpired()
{
    return Carbon::now()->greaterThan(Carbon::parse($this->expiry_date));
}

    /**
     * Relationship with the User model.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
