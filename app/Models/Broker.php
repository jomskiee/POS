<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Broker extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'name',
        'account_balance',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'account_balance' => 'decimal:2',
    ];

    /**
     * Get the user that owns the broker.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope to get brokers with positive balance
     */
    public function scopeWithPositiveBalance($query)
    {
        return $query->where('account_balance', '>', 0);
    }

    /**
     * Scope to get brokers by user
     */
    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Add to account balance based on sales
     */
    public function addToBalance($amount)
    {
        $this->increment('account_balance', $amount);
    }

    /**
     * Get formatted account balance
     */
    public function getFormattedBalanceAttribute()
    {
        return '$' . number_format($this->account_balance, 2);
    }
}