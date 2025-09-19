<?php

namespace App\Repositories;

use App\Models\Sales;
use App\Models\Broker;
use App\Models\InventoryLog;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class SalesRepository
{
    /**
     * Get total sales amount for active sales
     *
     * @return float
     */
    public function getTotalSalesAmount(): float
    {
        return Sales::active()->sum('paid_amount');
    }

    /**
     * Get total orders count for active sales
     *
     * @return int
     */
    public function getTotalOrdersCount(): int
    {
        return Sales::active()->count();
    }

    /**
     * Get recent orders with customer details and fishboxes sold
     *
     * @param int $limit
     * @return Collection
     */
    public function getRecentOrders(int $limit = 5): Collection
    {
        return Sales::with(['broker', 'salesDetails.fishBox.fishType'])
            ->active()
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * Get daily sales data for the last 7 days
     *
     * @return array
     */
    public function getDailySalesData(): array
    {
        $dailySales = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $dayName = $date->format('D');

            $sales = Sales::active()
                ->whereDate('sales_date', $date->format('Y-m-d'))
                ->sum('paid_amount');

            $dailySales[] = [
                'label' => $dayName,
                'value' => (float) $sales
            ];
        }

        return $dailySales;
    }

    /**
     * Get top 5 brokers with most sales this month
     *
     * @return Collection
     */
    public function getTopBrokersThisMonth(): Collection
    {
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();

        return Sales::with('broker')
            ->active()
            ->whereBetween('sales_date', [$startOfMonth, $endOfMonth])
            ->selectRaw('broker_id, COUNT(*) as sales_count, SUM(paid_amount) as total_sales')
            ->groupBy('broker_id')
            ->orderByDesc('sales_count')
            ->limit(5)
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
     * Get top 5 fish types most sold based on inventory logs
     *
     * @return Collection
     */
    public function getTopFishTypesSold(): Collection
    {
        return InventoryLog::join('fish_boxes', 'inventory_logs.fish_box_id', '=', 'fish_boxes.id')
            ->join('fish_types', 'fish_boxes.fish_type_id', '=', 'fish_types.id')
            ->where('inventory_logs.action', 'Sold')
            ->selectRaw('fish_types.id, fish_types.name, COUNT(inventory_logs.id) as total_sold')
            ->groupBy('fish_types.id', 'fish_types.name')
            ->orderByDesc('total_sold')
            ->limit(5)
            ->get()
            ->map(function ($item) {
                return [
                    'fish_type' => (object) [
                        'id' => $item->id,
                        'name' => $item->name
                    ],
                    'sold_count' => $item->total_sold
                ];
            });
    }
}
