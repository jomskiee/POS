<?php

namespace App\Models;

use App\Constants\UserStatusConstant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;

class Admin extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'address',
        'status',
    ];

    // ============== RELATIONS ============== //

    /**
     * @return BelongsTo
     */

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // ============== Scopes ============== //

    /**
     * @param mixed $query
     *
     * @return Builder
     */
    public function scopeActive($query): Builder
    {
        return $query->where('status', UserStatusConstant::ACTIVE);
    }

    /**
     * @param Builder $query
     *
     * @return Builder
     */
    public function scopeDeactivated($query): Builder
    {
        return $query->where('status', UserStatusConstant::DEACTIVATED);
    }

    /**
     * @param mixed $query
     * @param int $userId
     *
     * @return Builder
     */
    public function scopeByUser($query, $userId): Builder
    {
        return $query->where('user_id', $userId);
    }

    // ====================DATABASE OPERATIONS=========================//

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
