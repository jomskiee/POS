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
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Constants\FishBoxStatusConstant;
use App\Models\InventoryLog;

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

    // Scopes
    /**
     * Scope a query to only include active sales
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->whereIn('status', SalesStatusConstant::getAllActiveStatuses());
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
     * Create a new sales record with details and update fish box status
     *
     * @param array $salesData
     * @param array $salesDetails
     * @param int $brokerId
     * @param int $userId
     * @return Sales
     */
    public static function createSalesWithDetails(array $salesData, array $salesDetails, int $brokerId): Sales
    {
        return DB::transaction(function () use ($salesData, $salesDetails, $brokerId) {

            $userId = Auth::user()->id;
            // Create the sale
            $sale = self::create([
                'sales_date' => $salesData['sales_date'],
                'broker_id' => $brokerId,
                'total_amount' => $salesData['total_amount'],
                'buyer_name' => $salesData['buyer_name'],
                'buyer_contact' => $salesData['buyer_contact'] ?? null,
                'remarks' => $salesData['remarks'] ?? null,
                'details' => $salesData['details'] ?? null,
                'status' => SalesStatusConstant::ACTIVE
            ]);

            // Create sales details
            SalesDetails::createSalesDetails($sale->id, $brokerId, $salesDetails);

            // Update fish box status for each detail
            FishBox::updateFishBoxesForSales($brokerId, $salesDetails, $userId);

            return $sale;
        });
    }

    /**
     * Update an existing sales record with details and update fish box status
     *
     * @param Sales $sale
     * @param array $salesData
     * @param array $salesDetails
     * @param int $brokerId
     * @return void
     */
    public static function updateSalesWithDetails(Sales $sale, array $salesData, array $salesDetails, int $brokerId): void
    {
        DB::transaction(function () use ($sale, $salesData, $salesDetails, $brokerId) {
            $userId = Auth::user()->id;

            // Update the sale
            $sale->update([
                'sales_date' => $salesData['sales_date'],
                'total_amount' => $salesData['total_amount'],
                'buyer_name' => $salesData['buyer_name'],
                'buyer_contact' => $salesData['buyer_contact'] ?? null,
                'remarks' => $salesData['remarks'] ?? null,
                'details' => $salesData['details'] ?? null,
            ]);

            // Get old sales details before deleting
            $oldSalesDetails = $sale->salesDetails;

            // Reset fish boxes back to IN_STOCK status for old sales details
            foreach ($oldSalesDetails as $detail) {
                // Handle box_id as JSON array
                $boxIds = is_array($detail->box_id) ? $detail->box_id : [$detail->box_id];
                foreach ($boxIds as $boxId) {
                    FishBox::updateStatus($boxId, FishBoxStatusConstant::IN_STOCK, $userId);
                    InventoryLog::deleteLogForFishBox($boxId, $sale->created_at);
                }
            }

            // Update sales details - delete existing and create new ones
            $sale->salesDetails()->delete();

            // Create new sales details
            SalesDetails::createSalesDetails($sale->id, $brokerId, $salesDetails);

            // Update fish box status for new details
            FishBox::updateFishBoxesForSales($brokerId, $salesDetails, $userId);

            // Recalculate paid amount and update status
            $sale->updatePaidAmount();
            $sale->updatePaymentStatus();
        });
    }

    /**
     * @param string|null $search
     * @param string|null $status
     * @param int|null $brokerId
     * @param string|null $dateFrom
     * @param string|null $dateTo
     *
     * @return LengthAwarePaginator
     */
    public static function getPaginatedWithFilters(?string $search = null, ?string $status = null, ?int $brokerId, ?string $dateFrom = null, ?string $dateTo = null) : LengthAwarePaginator
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

        // Date range filtering
        if ($dateFrom) {
            $query->whereDate('sales_date', '>=', $dateFrom);
        }

        if ($dateTo) {
            $query->whereDate('sales_date', '<=', $dateTo);
        }


        $sales = $query->orderBy('created_at', 'desc')->paginate(15);

        // Add formatted items to each sale
        $sales->getCollection()->each(function ($sale) {
            $sale->formatted_items = $sale->getFormattedItems();
        });

        return $sales;
    }

    /**
     * @return void
     */
    public function deleteSales(): void
    {
        // Delete related sales details
        $this->salesDetails()->delete();

        // Mark the sale as deleted
        $this->update(['status' => SalesStatusConstant::DELETED]);
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
     * Get formatted sale ID in the format #000-000-001
     *
     * @return string
     */
    public function getFormattedIdAttribute(): string
    {
        $id = str_pad($this->id, 9, '0', STR_PAD_LEFT);
        return '#' . substr($id, 0, 3) . '-' . substr($id, 3, 3) . '-' . substr($id, 6, 3);
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

    /**
     * Get daily sales data for the last 7 days including today
     *
     * @param int|null $brokerId
     *
     * @return \Illuminate\Support\Collection
     */
    public static function getDailySalesLast7Days(?int $brokerId): \Illuminate\Support\Collection
    {
        $query = self::whereIn('status', SalesStatusConstant::getAllActiveStatuses())
            ->whereDate('sales_date', '>=', Carbon::now()->subDays(6))
            ->whereDate('sales_date', '<=', Carbon::now());

        if ($brokerId) {
            $query->where('broker_id', $brokerId);
        }

        $dailySales = $query->selectRaw('DATE(sales_date) as date, SUM(total_amount) as total_sales')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Create array for last 7 days with default values
        $last7Days = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i)->format('Y-m-d');
            $dayName = Carbon::now()->subDays($i)->format('D');

            $salesData = $dailySales->where('date', $date)->first();
            $totalSales = $salesData ? (float) $salesData->total_sales : 0;

            $last7Days[] = [
                'date' => $date,
                'day' => $dayName,
                'sales' => $totalSales
            ];
        }

        return collect($last7Days);
    }

    /**
     * Get analytics data for a specific date range
     *
     * @param int|null $brokerId
     * @param string|null $dateFrom
     * @param string|null $dateTo
     * @param string|null $status
     * @return array
     */
    public static function getAnalyticsData(?int $brokerId, ?string $dateFrom = null, ?string $dateTo = null, ?string $status = null): array
    {
        // Set default date range to last 7 days if not provided
        if (!$dateFrom) {
            $dateFrom = Carbon::now()->subDays(6)->format('Y-m-d');
        }
        if (!$dateTo) {
            $dateTo = Carbon::now()->format('Y-m-d');
        }

        $query = self::whereIn('status', SalesStatusConstant::getAllActiveStatuses())
            ->whereDate('sales_date', '>=', $dateFrom)
            ->whereDate('sales_date', '<=', $dateTo);

        if ($brokerId) {
            $query->where('broker_id', $brokerId);
        }

        if ($status) {
            $query->where('status', $status);
        }

        // Current period data
        $totalRevenue = $query->sum('paid_amount');
        $totalOrders = $query->count();
        $totalBalance = $query->sum('total_amount') - $query->sum('paid_amount');
        $totalFishBoxes = $query->withCount('salesDetails')->get()->sum('sales_details_count');

        // Get weekly sales data for the period
        $weeklySalesData = self::getDailySalesForPeriod($brokerId, $dateFrom, $dateTo, $status);

        // Get top selling items
        $topItems = self::getTopSellingItems($brokerId, $dateFrom, $dateTo, 5, $status);

        // Get payment methods breakdown
        $paymentMethods = SalesPayment::getPaymentMethodsBreakdown($brokerId, $dateFrom, $dateTo, $status);

        return [
            'totalRevenue' => $totalRevenue,
            'totalOrders' => $totalOrders,
            'totalBalance' => $totalBalance,
            'totalFishBoxes' => $totalFishBoxes,
            'weeklySalesData' => $weeklySalesData,
            'topItems' => $topItems,
            'paymentMethods' => $paymentMethods,
            'dateFrom' => $dateFrom,
            'dateTo' => $dateTo
        ];
    }

    /**
     * Get daily sales data for a specific period
     *
     * @param int|null $brokerId
     * @param string $dateFrom
     * @param string $dateTo
     * @param string|null $status
     * @return \Illuminate\Support\Collection
     */
    public static function getDailySalesForPeriod(?int $brokerId, string $dateFrom, string $dateTo, ?string $status = null): \Illuminate\Support\Collection
    {
        $query = self::whereIn('status', SalesStatusConstant::getAllActiveStatuses())
            ->whereDate('sales_date', '>=', $dateFrom)
            ->whereDate('sales_date', '<=', $dateTo);

        if ($brokerId) {
            $query->where('broker_id', $brokerId);
        }

        if ($status) {
            $query->where('status', $status);
        }

        $weeklySales = $query->selectRaw('YEARWEEK(sales_date, 1) as week, MIN(sales_date) as week_start, MAX(sales_date) as week_end, SUM(total_amount) as total_sales')
            ->groupBy('week')
            ->orderBy('week')
            ->get();

        // Create array for the period with weekly data
        $periodWeeks = [];
        $startDate = Carbon::parse($dateFrom)->startOfWeek();
        $endDate = Carbon::parse($dateTo)->endOfWeek();

        while ($startDate->lte($endDate)) {
            $weekStart = $startDate->format('Y-m-d');
            $weekEnd = $startDate->copy()->endOfWeek()->format('Y-m-d');

            // Check if start and end of week are in different months
            $startMonth = $startDate->format('M');
            $endMonth = $startDate->copy()->endOfWeek()->format('M');

            if ($startMonth === $endMonth) {
                // Same month: "Sep. 1-7"
                $weekLabel = $startDate->format('M. j') . '-' . $startDate->copy()->endOfWeek()->format('j');
            } else {
                // Different months: "Jul. 28- Aug. 3"
                $weekLabel = $startDate->format('M. j') . '- ' . $startDate->copy()->endOfWeek()->format('M. j');
            }

            // Find matching sales data by checking if the sales date falls within this week
            $salesData = $weeklySales->filter(function ($sale) use ($weekStart, $weekEnd) {
                $saleStart = Carbon::parse($sale->week_start)->format('Y-m-d');
                $saleEnd = Carbon::parse($sale->week_end)->format('Y-m-d');
                return $saleStart >= $weekStart && $saleEnd <= $weekEnd;
            })->first();

            $totalSales = $salesData ? (float) $salesData->total_sales : 0;

            $periodWeeks[] = [
                'date' => $weekStart,
                'day' => $weekLabel,
                'sales' => $totalSales,
                'week_start' => $weekStart,
                'week_end' => $weekEnd
            ];

            $startDate->addWeek();
        }

        return collect($periodWeeks);
    }

    /**
     * Get top selling items for a period
     *
     * @param int|null $brokerId
     * @param string $dateFrom
     * @param string $dateTo
     * @param int $limit
     * @param string|null $status
     * @return \Illuminate\Support\Collection
     */
    public static function getTopSellingItems(?int $brokerId, string $dateFrom, string $dateTo, int $limit = 5, ?string $status = null): \Illuminate\Support\Collection
    {
        $query = self::whereIn('status', SalesStatusConstant::getAllActiveStatuses())
            ->whereDate('sales_date', '>=', $dateFrom)
            ->whereDate('sales_date', '<=', $dateTo)
            ->with(['salesDetails']);

        if ($brokerId) {
            $query->where('broker_id', $brokerId);
        }

        if ($status) {
            $query->where('status', $status);
        }

        $sales = $query->get();

        // Aggregate items and their quantities
        $itemCounts = [];
        foreach ($sales as $sale) {
            foreach ($sale->salesDetails as $detail) {
                $item = $detail->item;
                if (!isset($itemCounts[$item])) {
                    $itemCounts[$item] = [
                        'name' => $item,
                        'quantity' => 0,
                        'revenue' => 0
                    ];
                }
                $itemCounts[$item]['quantity'] += 1;
                $itemCounts[$item]['revenue'] += $sale->total_amount / $sale->salesDetails->count();
            }
        }

        // Sort by quantity and take top items
        return collect($itemCounts)
            ->sortByDesc('quantity')
            ->take($limit)
            ->values();
    }

}
