<?php

namespace App\Repositories;

use App\Models\FishBox;
use App\Constants\FishBoxStatusConstant;

class InventoryRepository
{
    /**
     * Get inventory analysis data
     */
    public function getInventoryAnalysisData(): array
    {
        $stockStatus = [
            'In Stock' => FishBox::inStock()->count(),
            'Sold' => FishBox::sold()->count(),
            'Returned' => FishBox::returned()->count(),
            'Missing' => FishBox::missing()->count(),
        ];

        $totalFishBoxes = array_sum($stockStatus);
        $inStockCount = $stockStatus['In Stock'];
        $soldCount = $stockStatus['Sold'];
        $totalInventory = $inStockCount + $soldCount;
        $turnoverRate = $totalInventory > 0 ? ($soldCount / $totalInventory) * 100 : 0;

        // Calculate percentages for each status
        $stockStatusWithPercentages = [];
        foreach ($stockStatus as $statusName => $count) {
            $percentage = $totalFishBoxes > 0 ? ($count / $totalFishBoxes) * 100 : 0;
            $colorClass = $statusName === 'In Stock' ? 'bg-green-500' :
                         ($statusName === 'Sold' ? 'bg-blue-500' :
                         ($statusName === 'Returned' ? 'bg-yellow-500' : 'bg-red-500'));
            $bgClass = $statusName === 'In Stock' ? 'bg-green-50' :
                      ($statusName === 'Sold' ? 'bg-blue-50' :
                      ($statusName === 'Returned' ? 'bg-yellow-50' : 'bg-red-50'));

            $stockStatusWithPercentages[$statusName] = [
                'count' => $count,
                'percentage' => $percentage,
                'color_class' => $colorClass,
                'bg_class' => $bgClass
            ];
        }

        return [
            'stock_status' => $stockStatusWithPercentages,
            'total_fish_boxes' => $totalFishBoxes,
            'in_stock_count' => $inStockCount,
            'sold_count' => $soldCount,
            'total_inventory' => $totalInventory,
            'turnover_rate' => $turnoverRate
        ];
    }
}
