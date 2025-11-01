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
        'broker_id',
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
        return $this->belongsTo(FishType::class, 'fish_type_id');
    }

    /**
     * Get the broker that owns the fish box.
     */
    public function broker()
    {
        return $this->belongsTo(Broker::class, 'broker_id');
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


    // ============== SCOPES ============== //
    /**
     * Scope a query to only include returned fish boxes.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeReturned($query)
    {
        return $query->where('status', FishBoxStatusConstant::RETURNED);
    }

    /**
     * Scope a query to only include sold fish boxes.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSold($query)
    {
        return $query->where('status', FishBoxStatusConstant::SOLD);
    }

    /**
     * Scope a query to only include in stock fish boxes.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeInStock($query)
    {
        return $query->where('status', FishBoxStatusConstant::IN_STOCK);
    }

    /**
     * Scope a query to only include missing fish boxes.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeMissing($query)
    {
        return $query->where('status', FishBoxStatusConstant::MISSING);
    }

    // ============== DATABASE OPERATIONS ============== //
    /**
     * Create multiple fish boxes with unique names and QR codes
     *
     * @param int $fishTypeId
     * @param int $quantity
     * @return array
     */
    public static function createFishBoxes($fishTypeId, $quantity, $brokerId): array
    {
        $createdBoxes = [];

        for ($i = 0; $i < $quantity; $i++) {
            $fishBox = static::create([
                'name' => static::generateUniqueName(),
                'qr_code' => static::generateUniqueQrCode(),
                'fish_type_id' => $fishTypeId,
                'status' => FishBoxStatusConstant::IN_STOCK,
                'broker_id' => $brokerId,
            ]);

            // Create inventory log for the new fish box
            InventoryLog::createLogForFishBox($fishBox->id, $fishBox->status, $brokerId);

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
        $query = static::with(['fishType', 'broker', 'latestSale', 'salesDetails'])
            ->select('fish_boxes.*');

        // Apply search filter
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
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
            $query->where('broker_id', $brokerId);
        }

        // Order by creation date and id for consistent pagination
        return $query->orderBy('created_at', 'desc')->orderBy('id', 'desc')->paginate($perPage);
    }

     /**
     * Get available fish boxes for sale for a specific broker
     *
     * @param int $brokerId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function getAvailableForSale(int $brokerId)
    {
        return static::with('fishType')
            ->where('status', FishBoxStatusConstant::IN_STOCK)
            ->where('broker_id', $brokerId)
            ->get();
    }

    /**
     * Update fish box status
     *
     * @param int|array $fishBoxId
     * @param string $status
     * @param int $userId
     * @return bool
     */
    public static function updateStatus($fishBoxId, string $status, int $userId): bool
    {
        // Handle array of IDs
        if (is_array($fishBoxId)) {
            $fishBoxes = static::whereIn('id', $fishBoxId)->get();

            if ($fishBoxes->isEmpty()) {
                return false;
            }

            foreach ($fishBoxes as $fishBox) {
                $fishBox->update([
                    'status' => $status,
                ]);

                // Create inventory log for the status change
                InventoryLog::createLogForFishBox($fishBox->id, $status, $fishBox->broker_id);
            }

            return true;
        }

        // Handle single ID
        $fishBox = static::find($fishBoxId);

        if (!$fishBox) {
            return false;
        }

        $fishBox->update([
            'status' => $status,
        ]);

        // Create inventory log for the status change
        InventoryLog::createLogForFishBox($fishBox->id, $status, $fishBox->broker_id);

        return true;
    }

    /**
     * Update fish boxes status based on sales details for sold status
     *
     * @param int $brokerId
     * @param array $salesDetails
     * @param int $userId
     * @return void
     */
    public static function updateFishBoxesForSales(int $brokerId, array $salesDetails, int $userId): void
    {

        if (empty($salesDetails)) {
            return;
        }
        foreach ($salesDetails as $detail) {
            self::updateStatus(
                $detail['box_id'],
                FishBoxStatusConstant::SOLD,
                $userId
            );
        }
    }

    /**
     * @param int $fishBoxId
     * @param int $userId
     *
     * @return self
     */
    public static function updateFishBoxesForReturned(int $fishBoxId, int $userId): self
    {
        $fishBox = static::find($fishBoxId);

        // Update the fish box status to Returned
        $fishBox->status = FishBoxStatusConstant::RETURNED;
        $fishBox->save();

        // Create inventory log for the status change
        InventoryLog::createLogForFishBox($fishBox->id, FishBoxStatusConstant::RETURNED, $fishBox->broker_id);

        return $fishBox;
    }

    /**
     * @param string $qrCode
     * @param int $brokerId
     *
     * @return static|null
     */
    public static function getFishBoxByQrCode(string $qrCode, int $brokerId): ?self
    {
        return static::where('qr_code', $qrCode)->where('broker_id', $brokerId)->first();
    }

    /**
     * Get fish box by ID with broker validation
     *
     * @param int $id
     * @param int $brokerId
     *
     * @return static
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public static function getFishBoxByIdAndBroker(int $id, int $brokerId): self
    {
        return static::where('id', $id)->where('broker_id', $brokerId)->firstOrFail();
    }


    /**
     * @param int|null $brokerId
     *
     * @return int
     */
    public static function getTotalFishBoxes(?int $brokerId): int
    {
        $query = static::where('status', FishBoxStatusConstant::SOLD);

        if ($brokerId) {
            $query->where('broker_id', $brokerId);
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

    /**
     * Check if the fish box can be marked as missing
     *
     * @return bool
     */
    public function canBeMarkedAsMissing(): bool
    {
        return !in_array($this->status, [
            FishBoxStatusConstant::IN_STOCK,
            FishBoxStatusConstant::MISSING,
            FishBoxStatusConstant::RETURNED
        ]);
    }

    /**
     * Check if the fish box can be returned
     *
     * @return bool
     */
    public function canBeReturned(): bool
    {
        return !in_array($this->status, [
            FishBoxStatusConstant::IN_STOCK,
            FishBoxStatusConstant::MISSING,
            FishBoxStatusConstant::RETURNED
        ]);
    }

    /**
     * Check if the fish box can be edited
     *
     * @return bool
     */
    public function canBeEdited(): bool
    {
        return $this->status !== FishBoxStatusConstant::SOLD;
    }

    /**
     * Check if the fish box can be deleted
     *
     * @return bool
     */
    public function canBeDeleted(): bool
    {
        return !in_array($this->status, [
            FishBoxStatusConstant::SOLD,
            FishBoxStatusConstant::RETURNED
        ]);
    }

    /**
     * Return all returned fish boxes to in stock status for a specific broker
     *
     * @param int $brokerId
     * @return int
     */
    public static function returnAllToStock(int $brokerId): int
    {
        $returnedFishBoxes = static::returned()->where('broker_id', $brokerId)->get();

        if ($returnedFishBoxes->isEmpty()) {
            return 0;
        }

        $count = 0;
        foreach ($returnedFishBoxes as $fishBox) {
            // Update status to In Stock
            $fishBox->status = FishBoxStatusConstant::IN_STOCK;
            $fishBox->save();

            // Create inventory log for the status change
            InventoryLog::createLogForFishBox($fishBox->id, FishBoxStatusConstant::IN_STOCK, $fishBox->broker_id);

            $count++;
        }

        return $count;
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

}
