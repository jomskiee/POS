<?php

namespace App\Models;

use App\Constants\UserStatusConstant;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Broker extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'name',
        'address',
        'stall_name',
        'status',
    ];

    protected $casts = [
        //
    ];

    // ====================RELATIONS=========================//

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return HasMany
     */
    public function sales(): HasMany
    {
        return $this->hasMany(Sales::class, 'broker_id');
    }

    // ====================SCOPES=========================//

    /**
     * @param Builder $query
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
     * @param Builder $query
     *
     * @return Builder
     */

    /**
     * @param Builder $query
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
     * Create a new broker profile
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
     * Update broker profile data
     */
    public function updateProfile(array $data): bool
    {
        $updateData = [
            'name' => $data['name'],
            'address' => $data['address'],
        ];

        // Only update stall_name if it's provided in the data
        if (isset($data['stall_name'])) {
            $updateData['stall_name'] = $data['stall_name'];
        }

        return $this->update($updateData);
    }

    /**
     * Update broker status and sync with user
     */
    public function updateStatus(string $status): bool
    {
        $this->status = $status;
        $this->save();

        // Sync status with user
        $this->user->update(['status' => $status]);

        return true;
    }


    /**
     * Delete broker and deactivate user
     */
    public function deleteBroker(): bool
    {
        // Deactivate user before deleting broker profile
        $this->user->update(['status' => UserStatusConstant::DEACTIVATED]);

        return $this->delete();
    }

    public static function getBrokerIdByUserId($userId) : ?int
    {
        $broker = self::where('user_id', $userId)->first();
        return $broker ? $broker->id : null;
    }

}
