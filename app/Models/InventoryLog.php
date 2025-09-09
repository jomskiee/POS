<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Constants\InventoryLogActionConstant;
use App\Constants\FishBoxStatusConstant;

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
}
