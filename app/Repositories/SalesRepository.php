<?php

namespace App\Repositories;

use App\Constants\FishBoxStatusConstant;
use App\Models\Sales;
use App\Models\Broker;
use App\Models\InventoryLog;
use App\Constants\SalesStatusConstant;
use App\Models\FishBox;
use App\Models\SalesDetails;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class SalesRepository
{


    /**
     * Get top brokers for admin dashboard with filters
     *
     * @param string $dateFrom
     * @param string $dateTo
     * @param string|null $status
     * @param int $limit
     * @return Collection
     */
    public function getTopBrokersForAdmin(string $dateFrom, string $dateTo, ?string $status = null, int $limit = 5): Collection
    {
        $query = Sales::with('broker')
            ->active()
            ->whereDate('sales_date', '>=', $dateFrom)
            ->whereDate('sales_date', '<=', $dateTo);

        if ($status) {
            $query->where('status', $status);
        }

        return $query->selectRaw('broker_id, COUNT(*) as sales_count, SUM(paid_amount) as total_sales')
            ->groupBy('broker_id')
            ->orderByDesc('sales_count')
            ->limit($limit)
            ->get()
            ->map(function ($sale) {
                return [
                    'broker' => $sale->broker,
                    'sales_count' => $sale->sales_count,
                    'total_sales' => $sale->total_sales
                ];
            });
    }

    /**
     * Get daily sales data for admin dashboard with filters
     *
     * @param string $dateFrom
     * @param string $dateTo
     * @param string|null $status
     * @return array
     */
    public function getDailySalesDataForAdmin(string $dateFrom, string $dateTo, ?string $status = null): array
    {
        $dailySales = [];
        $startDate = Carbon::parse($dateFrom);
        $endDate = Carbon::parse($dateTo);
        $daysDiff = $startDate->diffInDays($endDate);

        // Limit to 7 days for chart display
        $chartDays = min($daysDiff + 1, 7);
        $chartStartDate = $endDate->copy()->subDays($chartDays - 1);

        for ($i = 0; $i < $chartDays; $i++) {
            $date = $chartStartDate->copy()->addDays($i);
            $dayName = $date->format('D');

            $query = Sales::active()
                ->whereDate('sales_date', $date->format('Y-m-d'));

            if ($status) {
                $query->where('status', $status);
            }

            $sales = $query->sum('paid_amount');

            $dailySales[] = [
                'label' => $dayName,
                'value' => (float) $sales
            ];
        }

        return $dailySales;
    }

    /**
     * Get total revenue for admin with search functionality
     *
     * @param string $dateFrom
     * @param string $dateTo
     * @param string|null $status
     * @param string|null $search
     * @return float
     */
    public function getTotalRevenueForAdminWithSearch(string $dateFrom, string $dateTo, ?string $status = null, ?string $search = null): float
    {
        $query = Sales::active()
            ->whereDate('sales_date', '>=', $dateFrom)
            ->whereDate('sales_date', '<=', $dateTo);

        if ($status) {
            $query->where('status', $status);
        }

        // Add search functionality
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('buyer_name', 'like', "%{$search}%")
                  ->orWhereHas('broker', function ($brokerQuery) use ($search) {
                      $brokerQuery->where('name', 'like', "%{$search}%");
                  });
            });
        }

        return $query->sum('total_amount');
    }

    /**
     * Get total orders count for admin with search functionality
     *
     * @param string $dateFrom
     * @param string $dateTo
     * @param string|null $status
     * @param string|null $search
     * @return int
     */
    public function getTotalOrdersForAdminWithSearch(string $dateFrom, string $dateTo, ?string $status = null, ?string $search = null): int
    {
        $query = Sales::active()
            ->whereDate('sales_date', '>=', $dateFrom)
            ->whereDate('sales_date', '<=', $dateTo);

        if ($status) {
            $query->where('status', $status);
        }

        // Add search functionality
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('buyer_name', 'like', "%{$search}%")
                  ->orWhereHas('broker', function ($brokerQuery) use ($search) {
                      $brokerQuery->where('name', 'like', "%{$search}%");
                  });
            });
        }

        return $query->count();
    }

    /**
     * Get paginated sales with filters for admin (includes broker search)
     *
     * @param string|null $search
     * @param string|null $status
     * @param int|null $brokerId
     * @param string|null $dateFrom
     * @param string|null $dateTo
     * @return LengthAwarePaginator
     */
    public function getPaginatedWithFiltersForAdmin(?string $search = null, ?string $status = null, ?int $brokerId, ?string $dateFrom = null, ?string $dateTo = null): LengthAwarePaginator
    {
        $query = Sales::with(['broker', 'salesDetails', 'salesPayments'])
            ->whereIn('status', SalesStatusConstant::getAllActiveStatuses());

        if ($brokerId) {
            $query->where('broker_id', $brokerId);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('buyer_name', 'like', "%{$search}%")
                  ->orWhere('buyer_contact', 'like', "%{$search}%")
                  ->orWhereHas('broker', function ($brokerQuery) use ($search) {
                      $brokerQuery->where('name', 'like', "%{$search}%");
                  });
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
     * Get total revenue for admin dashboard
     *
     * @param string $dateFrom
     * @param string $dateTo
     * @param string|null $status
     * @return float
     */
    public function getTotalRevenueForAdmin(string $dateFrom, string $dateTo, ?string $status = null): float
    {
        $query = Sales::active()
            ->whereDate('sales_date', '>=', $dateFrom)
            ->whereDate('sales_date', '<=', $dateTo);

        if ($status) {
            $query->where('status', $status);
        }

        return $query->sum('total_amount');
    }

    /**
     * Get total orders count for admin dashboard
     *
     * @param string $dateFrom
     * @param string $dateTo
     * @param string|null $status
     * @return int
     */
    public function getTotalOrdersForAdmin(string $dateFrom, string $dateTo, ?string $status = null): int
    {
        $query = Sales::active()
            ->whereDate('sales_date', '>=', $dateFrom)
            ->whereDate('sales_date', '<=', $dateTo);

        if ($status) {
            $query->where('status', $status);
        }

        return $query->count();
    }

    /**
     * Get recent orders for admin dashboard
     *
     * @param string $dateFrom
     * @param string $dateTo
     * @param string|null $status
     * @param int $limit
     * @return Collection
     */
    public function getRecentOrdersForAdmin(string $dateFrom, string $dateTo, ?string $status = null, int $limit = 5): Collection
    {
        $query = Sales::with(['broker', 'salesDetails.fishBox.fishType'])
            ->active()
            ->whereDate('sales_date', '>=', $dateFrom)
            ->whereDate('sales_date', '<=', $dateTo);

        if ($status) {
            $query->where('status', $status);
        }

        return $query->orderBy('created_at', 'desc')->limit($limit)->get();
    }

    /**
     * Get sales status breakdown data
     *
     * @param string $dateFrom
     * @param string $dateTo
     * @param string|null $status
     *
     * @return array
     */
    public function getSalesStatusBreakdown(string $dateFrom, string $dateTo, ?string $status): array
    {
        $statusBreakdown = [];
        $salesStatuses = SalesStatusConstant::getAllActiveStatuses();

        foreach ($salesStatuses as $statusValue) {
            $statusQuery = Sales::active()->whereBetween('sales_date', [$dateFrom, $dateTo]);
            if ($status) {
                $statusQuery->where('status', $status);
            }

            $count = $statusQuery->where('status', $statusValue)->count();
            $totalAmount = $statusQuery->where('status', $statusValue)->sum('paid_amount');

            $statusBreakdown[$statusValue] = [
                'count' => $count,
                'total_amount' => $totalAmount,
                'display_name' => SalesStatusConstant::getDisplayName($statusValue),
                'color_class' => SalesStatusConstant::getStatusColorClasses($statusValue),
                'bg_class' => $this->getStatusBackgroundClass($statusValue),
                'progress_color' => $this->getStatusProgressColor($statusValue)
            ];
        }

        $totalStatusOrders = array_sum(array_column($statusBreakdown, 'count'));

        // Calculate percentages
        foreach ($statusBreakdown as $statusValue => &$data) {
            $data['percentage'] = $totalStatusOrders > 0 ? ($data['count'] / $totalStatusOrders) * 100 : 0;
        }

        return [
            'breakdown' => $statusBreakdown,
            'total_orders' => $totalStatusOrders
        ];
    }

    /**
     * Get payment conversion analysis data
     *
     * @param string $dateFrom
     * @param string $dateTo
     *
     * @return array
     */
    public function getPaymentConversionData(string $dateFrom, string $dateTo): array
    {
        $activeOrders = Sales::active()->whereBetween('sales_date', [$dateFrom, $dateTo])->where('status', SalesStatusConstant::ACTIVE)->count();
        $paidOrders = Sales::active()->whereBetween('sales_date', [$dateFrom, $dateTo])->where('status', SalesStatusConstant::PAID)->count();
        $partiallyPaidOrders = Sales::active()->whereBetween('sales_date', [$dateFrom, $dateTo])->where('status', SalesStatusConstant::PARTIALLY_PAID)->count();
        $totalOrders = $activeOrders + $paidOrders + $partiallyPaidOrders;

        return [
            'active_orders' => $activeOrders,
            'paid_orders' => $paidOrders,
            'partially_paid_orders' => $partiallyPaidOrders,
            'total_orders' => $totalOrders,
            'conversion_rate' => $totalOrders > 0 ? ($paidOrders / $totalOrders) * 100 : 0,
            'partial_conversion_rate' => $totalOrders > 0 ? ($partiallyPaidOrders / $totalOrders) * 100 : 0,
        ];
    }

    /**
     * Get background color class for status
     */
    private function getStatusBackgroundClass(string $status): string
    {
        return match ($status) {
            SalesStatusConstant::PAID => 'bg-green-50',
            SalesStatusConstant::ACTIVE => 'bg-yellow-50',
            SalesStatusConstant::PARTIALLY_PAID => 'bg-blue-50',
            default => 'bg-gray-50'
        };
    }

    /**
     * Get progress bar color class for status
     */
    private function getStatusProgressColor(string $status): string
    {
        return match ($status) {
            SalesStatusConstant::PAID => 'bg-green-500',
            SalesStatusConstant::ACTIVE => 'bg-yellow-500',
            SalesStatusConstant::PARTIALLY_PAID => 'bg-blue-500',
            default => 'bg-gray-500'
        };
    }

    /**
     * Get top brokers this month with fishbox count
     *
     * @return Collection
     */
    public function getTopBrokersWithFishBoxCount(): Collection
    {
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();

        return Sales::with('broker')
            ->active()
            ->whereBetween('sales_date', [$startOfMonth, $endOfMonth])
            ->selectRaw('id, broker_id, COUNT(*) as sales_count, SUM(paid_amount) as total_sales')
            ->groupBy('broker_id')
            ->orderByDesc('sales_count')
            ->limit(5)
            ->get()
            ->map(function ($sale) use ($startOfMonth, $endOfMonth) {
                $fishBoxCount = SalesDetails::whereHas('sales', function ($query) use ($sale, $startOfMonth, $endOfMonth) {
                        $query->where('broker_id', $sale->broker_id)
                            ->whereBetween('sales_date', [$startOfMonth, $endOfMonth]);
                    })
                    ->count();

                return [
                    'broker' => $sale->broker,
                    'sales_count' => $sale->sales_count,
                    'total_sales' => $sale->total_sales,
                    'fishbox_count' => $fishBoxCount
                ];
            });
    }
}
