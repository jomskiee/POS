<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Log;

class SalesDetails extends Model
{
    use HasFactory;

    protected $fillable = [
        'sales_id',
        'broker_id',
        'box_id',
        'item',
        'item_description',
        'unit_price',
        'quantity',
        'sub_total'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'box_id' => 'array',
        'unit_price' => 'decimal:2',
        'sub_total' => 'decimal:2',
    ];

    // ============== RELATIONS ============== //

    /**
     * Get the sales that this sales detail belongs to
     *
     * @return BelongsTo
     */
    public function sales(): BelongsTo
    {
        return $this->belongsTo(Sales::class, 'sales_id');
    }

    /**
     * Get the broker that this sales detail belongs to
     *
     * @return BelongsTo
     */
    public function broker(): BelongsTo
    {
        return $this->belongsTo(Broker::class, 'broker_id');
    }

    /**
     * Get the fish boxes that this sales detail belongs to
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function fishBoxes()
    {
        if (is_array($this->box_id) && !empty($this->box_id)) {
            return FishBox::whereIn('id', $this->box_id)->get();
        }
        return collect();
    }

    /**
     * Get the first fish box for backward compatibility
     *
     * @return FishBox|null
     */
    public function getFirstFishBoxAttribute(): ?FishBox
    {
        if (is_array($this->box_id) && !empty($this->box_id)) {
            return FishBox::find($this->box_id[0]);
        }
        return null;
    }

    /**
     * Get the fish box relationship (backward compatibility)
     * This returns the first fish box for compatibility with existing code
     * Since box_id is now a JSON array, we use a custom approach
     *
     * @return FishBox|null
     */
    public function fishBox()
    {
        if (is_array($this->box_id) && !empty($this->box_id)) {
            return FishBox::find($this->box_id[0]);
        }
        return null;
    }

    /**
     * Get all fish box IDs as an array
     *
     * @return array
     */
    public function getBoxIdsAttribute(): array
    {
        return is_array($this->box_id) ? $this->box_id : [];
    }

    /**
     * Get the count of fish boxes
     *
     * @return int
     */
    public function getBoxCountAttribute(): int
    {
        return count($this->box_ids);
    }

    /**
     * Check if a specific fish box ID is in this sales detail
     *
     * @param int $boxId
     * @return bool
     */
    public function hasBoxId(int $boxId): bool
    {
        return in_array($boxId, $this->box_ids);
    }

    // ============== DATABASE OPERATIONS ============== //

    /**
     * Create sales details for a sale
     *
     * @param int $salesId
     * @param int $brokerId
     * @param array $details
     * @return void
     */
    public static function createSalesDetails(int $salesId, int $brokerId, array $details): void
    {
        if (empty($details)) {
            return;
        }

        foreach ($details as $detail) {
            // Store box_id as array of IDs
            $boxIds = is_array($detail['box_id']) ? $detail['box_id'] : [$detail['box_id']];

            self::create([
                'sales_id' => $salesId,
                'broker_id' => $brokerId,
                'box_id' => $boxIds, // Store as JSON array
                'item' => $detail['item'],
                'item_description' => $detail['item_description'] ?? null,
                'unit_price' => $detail['unit_price'] ?? null,
                'quantity' => $detail['quantity'] ?? count($boxIds), // Use actual quantity
                'sub_total' => $detail['sub_total'] ?? null // Use calculated sub total
            ]);
        }
    }
}
