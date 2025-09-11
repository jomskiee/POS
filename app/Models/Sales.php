<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;
use App\Constants\SalesStatusConstant;
use Carbon\Carbon;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Sales extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'sales_date',
        'broker_id',
        'total_amount',
        'paid_amount',
        'buyer_name',
        'buyer_contact',
        'remarks',
        'details',
        'status'
    ];

    protected $casts = [
        'sales_date' => 'datetime',
        'total_amount' => 'decimal:2',
        'paid_amount' => 'decimal:2',
        'details' => 'array',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->uuid)) {
                $model->uuid = Str::uuid();
            }
        });
    }

    // Relationships
    /**
     * @return BelongsTo
     */
    public function broker() : BelongsTo
    {
        return $this->belongsTo(Broker::class, 'broker_id');
    }

    /**
     * @return HasMany
     */
    public function salesDetails() : HasMany
    {
        return $this->hasMany(SalesDetails::class, 'sales_id');
    }

    /**
     * @return HasMany
     */
    public function salesPayments() : HasMany
    {
        return $this->hasMany(SalesPayment::class, 'sales_id');
    }

    // Helper methods
    /**
     * @return float
     */
    public function getRemainingAmountAttribute() : float
    {
        return $this->total_amount - $this->paid_amount;
    }

    /**
     * @return void
     */
    public function updatePaymentStatus() : void
    {
        if ($this->paid_amount <= 0) {
            $this->status = SalesStatusConstant::ACTIVE;
        } elseif ($this->paid_amount >= $this->total_amount) {
            $this->status = SalesStatusConstant::PAID;
        } else {
            $this->status = SalesStatusConstant::PARTIALLY_PAID;
        }
        $this->save();
    }

    /**
     * @return void
     */
    public function updatePaidAmount() : void
    {
        $this->paid_amount = $this->salesPayments()
            ->where('status', 'Active')
            ->sum('paid_amount');
        $this->save();
    }

    /**
     * @param null $search
     * @param null $status
     * @param int|null $brokerId
     *
     * @return LengthAwarePaginator
     */
    public static function getPaginatedWithFilters($search = null, $status = null, ?int $brokerId) : LengthAwarePaginator
    {
        $query = self::with(['broker', 'salesDetails', 'salesPayments'])
            ->whereIn('status', SalesStatusConstant::getAllActiveStatuses());

        if ($brokerId) {
            $query->where('broker_id', $brokerId);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('buyer_name', 'like', "%{$search}%")
                  ->orWhere('buyer_contact', 'like', "%{$search}%");
            });
        }

        if ($status) {
            $query->where('status', $status);
        }

        return $query->orderBy('created_at', 'desc')->paginate(15);
    }

    /**
     * @return void
     */
    public function deleteSales(): void
    {
        self::update(['status' => SalesStatusConstant::DELETED]);
    }

    /**
     * @param int|null $brokerId
     *
     * @return float
     */
    public static function getTotalSalesToday(?int $brokerId): float
    {
        $query = self::whereIn('status', SalesStatusConstant::getAllActiveStatuses())
            ->whereDate('sales_date', today());

        if ($brokerId) {
            $query->where('broker_id', $brokerId);
        }

        return $query->sum('paid_amount');
    }

    /**
     * @param int|null $brokerId
     *
     * @return float
     */
    public static function getTotalPaidAmountToday(?int $brokerId): float
    {
        $query = self::whereIn('status', SalesStatusConstant::getAllActiveStatuses())
            ->whereDate('sales_date', today());

        if ($brokerId) {
            $query->where('broker_id', $brokerId);
        }

        return $query->sum('paid_amount');
    }

    /**
     * @param int|null $brokerId
     *
     * @return float
     */
    public static function getTotalPaidAmountYesterday(?int $brokerId): float
    {
        $query = self::whereIn('status', SalesStatusConstant::getAllActiveStatuses())
            ->whereDate('sales_date', Carbon::yesterday());

        if ($brokerId) {
            $query->where('broker_id', $brokerId);
        }

        return $query->sum('paid_amount');
    }

    /**
     * @param int $limit
     * @param int|null $brokerId
     *
     * @return Collection
     */
    public static function getRecentSales($limit = 4, ?int $brokerId): Collection
    {
        $query = self::with(['broker', 'salesDetails'])
            ->whereIn('status', SalesStatusConstant::getAllActiveStatuses());

        if ($brokerId) {
            $query->where('broker_id', $brokerId);
        }

        $sales = $query->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();

        // Add formatted items to each sale
        $sales->each(function ($sale) {
            $sale->formatted_items = $sale->getFormattedItems();
        });

        return $sales;
    }

    /**
     * @return string
     */
    public function getFormattedItems(): string
    {
        return $this->salesDetails->pluck('item')->implode(', ');
    }


    /**
     * @param int|null $brokerId
     *
     * @return float
     */
    public static function getTotalSalesBalance(?int $brokerId): float
    {
        $query = self::whereIn('status', SalesStatusConstant::getAllActiveStatuses());

        if ($brokerId) {
            $query->where('broker_id', $brokerId);
        }

        return $query->selectRaw('SUM(total_amount - paid_amount) as balance')
            ->value('balance') ?? 0;
    }

    /**
     * @param int|null $brokerId
     *
     * @return int
     */
    public static function getTotalOrdersToday(?int $brokerId): int
    {
        $query = self::whereIn('status', SalesStatusConstant::getAllActiveStatuses())
            ->whereDate('sales_date', today());

        if ($brokerId) {
            $query->where('broker_id', $brokerId);
        }

        return $query->count();
    }
}
