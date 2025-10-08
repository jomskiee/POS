<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
     * Get the fish box that this sales detail belongs to
     *
     * @return BelongsTo
     */
    public function fishBox(): BelongsTo
    {
        return $this->belongsTo(FishBox::class, 'box_id');
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
            // Handle multiple fish boxes for the same sales detail
            $boxIds = is_array($detail['box_id']) ? $detail['box_id'] : [$detail['box_id']];

            foreach ($boxIds as $boxId) {
                self::create([
                    'sales_id' => $salesId,
                    'broker_id' => $brokerId,
                    'box_id' => $boxId,
                    'item' => $detail['item'],
                    'item_description' => $detail['item_description'] ?? null,
                    'unit_price' => $detail['unit_price'] ?? null,
                    'quantity' => 1, // Each fish box represents quantity 1
                    'sub_total' => $detail['unit_price'] ?? null // Sub total per fish box
                ]);
            }
        }
    }
}
