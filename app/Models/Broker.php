<?php

namespace App\Models;

use App\Constants\UserStatusConstant;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Broker extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'name',
        'address',
        'account_balance',
        'status',
    ];

    protected $casts = [
        'account_balance' => 'decimal:2',
    ];

    // ====================RELATIONS=========================//

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
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
    public function scopeWithPositiveBalance($query): Builder
    {
        return $query->where('account_balance', '>', 0);
    }

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
            'account_balance' => 0.00, // Always default to 0
            'status' => UserStatusConstant::ACTIVE,
        ]);
    }

    /**
     * Update broker profile data
     */
    public function updateProfile(array $data): bool
    {
        return $this->update([
            'name' => $data['name'],
            'address' => $data['address']
        ]);
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

    public function addToBalance($amount)
    {
        $this->increment('account_balance', $amount);
    }

    public function minusFromBalance($amount)
    {
        $this->decrement('account_balance', $amount);
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

    public static function getBrokerIdByUserId($userId) : int
    {
        return self::where('user_id', $userId)->first()->id;
    }

    public static function getBrokerBalanceByUserId($userId) : float
    {
        return self::where('user_id', $userId)->first()->account_balance;
    }
}
