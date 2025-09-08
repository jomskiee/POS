<?php

namespace App\Models;

use App\Constants\UserStatusConstant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Admin extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'address',
        'status',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopeActive($query)
    {
        return $query->where('status', UserStatusConstant::ACTIVE);
    }

    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Create a new admin profile
     */
    public static function createProfile(int $userId, array $data): self
    {
        return static::create([
            'user_id' => $userId,
            'name' => $data['name'],
            'address' => $data['address'],
            'status' => UserStatusConstant::ACTIVE,
        ]);
    }

    /**
     * Find admin by user ID
     */
    public static function findAdminByUserId(int $userId): ?self
    {
        return static::where('user_id', $userId)->first();
    }

    /**
     * Update admin profile data
     */
    public function updateProfile(array $data): bool
    {
        return $this->update([
            'name' => $data['name'],
            'address' => $data['address']
        ]);
    }

    /**
     * Update admin status and sync with user
     */
    public function updateStatus(string $status): bool
    {
        $this->status = $status;
        $this->save();

        // Sync status with user
        $this->user->update(['status' => $status]);

        return true;
    }
}
