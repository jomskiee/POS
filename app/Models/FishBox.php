<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use App\Constants\FishBoxStatusConstant;
use Illuminate\Support\Str;

class FishBox extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'qr_code',
        'fish_type_id',
        'status',
        'current_broker_id',
    ];

    protected $casts = [
        'qr_code' => 'string',
    ];

    protected $appends = ['buyer_contacts', 'buyer_names'];

    // ============== RELATIONS ============== //
    /**
     * Get the fish type that owns the fish box.
     */
    public function fishType()
    {
        return $this->belongsTo(FishType::class);
    }

    /**
     * Get the current broker that owns the fish box.
     */
    public function currentBroker()
    {
        return $this->belongsTo(Broker::class, 'current_broker_id');
    }

    /**
     * Get the inventory logs for this fish box.
     */
    public function inventoryLogs()
    {
        return $this->hasMany(InventoryLog::class);
    }

    /**
     * Get the sales details for this fish box.
     */
    public function salesDetails()
    {
        return $this->hasMany(SalesDetails::class, 'box_id');
    }

    /**
     * Get the sales that include this fish box.
     */
    public function sales()
    {
        return $this->belongsToMany(Sales::class, 'sales_details', 'box_id', 'sales_id')
                    ->withTimestamps();
    }

    /**
     * Get the latest sale for this fish box.
     */
    public function latestSale()
    {
        return $this->belongsToMany(Sales::class, 'sales_details', 'box_id', 'sales_id')
                    ->withTimestamps()
                    ->latest('sales.created_at');
    }

    // ============== DATABASE OPERATIONS ============== //
    /**
     * Create multiple fish boxes with unique names and QR codes
     *
     * @param int $fishTypeId
     * @param int $quantity
     * @param int $userId
     * @return array
     */
    public static function createFishBoxes($fishTypeId, $quantity, $userId): array
    {
        $createdBoxes = [];

        for ($i = 0; $i < $quantity; $i++) {
            $fishBox = static::create([
                'name' => static::generateUniqueName(),
                'qr_code' => static::generateUniqueQrCode(),
                'fish_type_id' => $fishTypeId,
                'status' => FishBoxStatusConstant::IN_STOCK,
                'current_broker_id' => null,
            ]);

            // Create inventory log for the new fish box
            InventoryLog::createLogForFishBox($fishBox->id, $fishBox->status, $userId);

            $createdBoxes[] = $fishBox;
        }

        return $createdBoxes;
    }

      /**
     * Get paginated fish boxes with search and filter functionality
     *
     * @param string|null $search
     * @param string|null $status
     * @param int|null $fishTypeId
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public static function getPaginatedWithFilters(?string $search = null, ?string $status = null, ?int $fishTypeId = null, int $perPage = 12, ?int $brokerId = null): LengthAwarePaginator
    {
        $query = static::with(['fishType', 'currentBroker', 'latestSale', 'salesDetails'])
            ->select('fish_boxes.*')
            ->selectRaw('NOT (status = ? OR status = ?) as can_delete', [
                FishBoxStatusConstant::SOLD,
                FishBoxStatusConstant::RETURNED
            ]);

        // Apply search filter
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('qr_code', 'like', '%' . $search . '%')
                  ->orWhereHas('fishType', function ($subQ) use ($search) {
                      $subQ->where('name', 'like', '%' . $search . '%');
                  });
            });
        }

        // Apply status filter
        if ($status) {
            $query->where('status', $status);
        }

        // Apply fish type filter
        if ($fishTypeId) {
            $query->where('fish_type_id', $fishTypeId);
        }

        // Apply broker filter
        if ($brokerId) {
            $query->where('current_broker_id', $brokerId);
        }

        // Order by creation date and id for consistent pagination
        return $query->orderBy('created_at', 'desc')->orderBy('id', 'desc')->paginate($perPage);
    }

    /**
     * Generate a unique fish box name
     *
     * @return string
     */
    protected static function generateUniqueName(): string
    {
        do {
            // Get the next sequential number
            $lastFishBox = static::withTrashed()->orderBy('id', 'desc')->first();
            $nextNumber = $lastFishBox ? $lastFishBox->id + 1 : 1;

            // Format as "Fish Box #01", "Fish Box #02", etc.
            $name = 'Fish Box #' . str_pad($nextNumber, 2, '0', STR_PAD_LEFT);

            // Check if this name already exists
            $exists = static::withTrashed()->where('name', $name)->exists();
        } while ($exists);

        return $name;
    }

    /**
     * Generate a unique QR code
     *
     * @return string
     */
    protected static function generateUniqueQrCode(): string
    {
        do {
            // Generate a unique UUID for QR code
            $qrCode = Str::uuid()->toString();

            // Check if this QR code already exists
            $exists = static::withTrashed()->where('qr_code', $qrCode)->exists();
        } while ($exists);

        return $qrCode;
    }

    /**
     * Get available fish boxes for sale
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function getAvailableForSale()
    {
        return static::with('fishType')
            ->where('status', FishBoxStatusConstant::IN_STOCK)
            ->whereNull('current_broker_id')
            ->get();
    }

    /**
     * Update fish box broker ID and status
     *
     * @param int $fishBoxId
     * @param int|null $currentBrokerId
     * @param string $status
     * @param int $userId
     * @return bool
     */
    public static function updateBrokerAndStatus(int $fishBoxId, ?int $currentBrokerId, string $status, int $userId): bool
    {
        $fishBox = static::find($fishBoxId);

        if (!$fishBox) {
            return false;
        }

        $fishBox->update([
            'current_broker_id' => $currentBrokerId,
            'status' => $status,
        ]);

        // Create inventory log for the status change
        InventoryLog::createLogForFishBox($fishBox->id, $status, $userId);

        return true;
    }


    public static function getTotalFishBoxes(?int $brokerId): int
    {
        $query = static::where('status', FishBoxStatusConstant::SOLD);

        if ($brokerId) {
            $query->where('current_broker_id', $brokerId);
        }

        return $query->count();
    }

    /**
     * Get buyer contact for the latest sale of this fish box
     *
     * @return string|null
     */
    public function getBuyerContactsAttribute()
    {
        $latestSale = $this->latestSale->first();
        return $latestSale ? $latestSale->buyer_contact : null;
    }

    /**
     * Get buyer name for the latest sale of this fish box
     *
     * @return string|null
     */
    public function getBuyerNamesAttribute()
    {
        $latestSale = $this->latestSale->first();
        return $latestSale ? $latestSale->buyer_name : null;
    }
}
