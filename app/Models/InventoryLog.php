<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Constants\InventoryLogActionConstant;
use App\Constants\FishBoxStatusConstant;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;

class InventoryLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'fish_box_id',
        'action',
        'user_id',
    ];

    // ============== RELATIONS ============== //
    /**
     * Get the fish box that owns the inventory log.
     */
    public function fishBox()
    {
        return $this->belongsTo(FishBox::class);
    }

    /**
     * Get the user that created the inventory log.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // ============== SCOPES ============== //

    /**
     * Scope to filter by action
     *
     * @param Builder $query
     * @param string $action
     * @return Builder
     */
    public function scopeByAction(Builder $query, string $action): Builder
    {
        return $query->where('action', $action);
    }

    /**
     * Scope to filter by date range
     *
     * @param Builder $query
     * @param string $dateFrom
     * @param string $dateTo
     * @return Builder
     */
    public function scopeByDateRange(Builder $query, ?string $dateFrom = null, ?string $dateTo = null): Builder
    {
        if ($dateFrom) {
            $query->whereDate('created_at', '>=', $dateFrom);
        }

        if ($dateTo) {
            $query->whereDate('created_at', '<=', $dateTo);
        }

        return $query;
    }

    /**
     * Scope to filter by specific date
     *
     * @param Builder $query
     * @param string $date
     * @return Builder
     */
    public function scopeByDate(Builder $query, string $date): Builder
    {
        return $query->whereDate('created_at', $date);
    }

    // ============== DATABASE OPERATIONS ============== //
    /**
     * Create an inventory log for a fish box based on its status
     *
     * @param int $fishBoxId
     * @param string $status
     * @param int $userId
     * @return self
     */
    public static function createLogForFishBox($fishBoxId, $status, $userId): self
    {
        $action = static::getActionFromStatus($status);

        return static::create([
            'fish_box_id' => $fishBoxId,
            'action' => $action,
            'user_id' => $userId,
        ]);
    }

    /**
     * Get summary statistics for a specific date
     *
     * @param string $date
     * @return array
     */
    public static function getSummaryForDate(string $date): array
    {
        return [
            'stocked' => static::byAction(InventoryLogActionConstant::STOCKED)
                ->byDate($date)->count(),
            'sold' => static::byAction(InventoryLogActionConstant::SOLD)
                ->byDate($date)->count(),
            'returned' => static::byAction(InventoryLogActionConstant::RETURNED)
                ->byDate($date)->count(),
            'missing' => static::byAction(InventoryLogActionConstant::MISSING)
                ->byDate($date)->count(),
        ];
    }

    /**
     * Get paginated inventory logs with filters
     *
     * @param string|null $action
     * @param string|null $dateFrom
     * @param string|null $dateTo
     * @param int $perPage
     *
     * @return LengthAwarePaginator
     */
    public static function getPaginatedWithFilters(?string $action, ?string $dateFrom, ?string $dateTo, int $perPage = 12): LengthAwarePaginator
    {
        $query = static::with(['fishBox.fishType', 'user']);

        // Apply action filter using scope
        if ($action) {
            $query->byAction($action);
        }

        // Apply date range filter using scope
        $query->byDateRange($dateFrom, $dateTo);

        return $query->orderBy('created_at', 'desc')->paginate($perPage);
    }

    /**
     * Map fish box status to inventory log action
     *
     * @param string $status
     * @return string
     */
    protected static function getActionFromStatus($status): string
    {
        switch ($status) {
            case FishBoxStatusConstant::IN_STOCK:
                return InventoryLogActionConstant::STOCKED;
            case FishBoxStatusConstant::SOLD:
                return InventoryLogActionConstant::SOLD;
            case FishBoxStatusConstant::RETURNED:
                return InventoryLogActionConstant::RETURNED;
            case FishBoxStatusConstant::MISSING:
                return InventoryLogActionConstant::MISSING;
            default:
                return InventoryLogActionConstant::STOCKED; // Default fallback
        }
    }

    /**
     * @param int $fishBoxId
     * @param int $userId
     * @param Carbon $createdAt
     *
     * @return int
     */
    public static function deleteLogForFishBox(int $fishBoxId, int $userId, Carbon $createdAt): int
    {
        $from = $createdAt->copy()->subMinute();
        $to = $createdAt->copy()->addMinute();

        return static::where('fish_box_id', $fishBoxId)
            ->where('user_id', $userId)
            ->where('action', InventoryLogActionConstant::SOLD)
            ->whereBetween('created_at', [$from, $to])
            ->delete();
    }
}
