<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Constants\SalesStatusConstant;

class SalesPayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'sales_id',
        'broker_id',
        'paid_amount',
        'payment_date',
        'status',
        'payment_method'
    ];

    protected $casts = [
        'payment_date' => 'date',
        'paid_amount' => 'decimal:2',
    ];

    // Relationships
    public function sales()
    {
        return $this->belongsTo(Sales::class, 'sales_id');
    }

    public function broker()
    {
        return $this->belongsTo(Broker::class, 'broker_id');
    }

    /**
     * Get payment methods breakdown for a period
     *
     * @param int|null $brokerId
     * @param string $dateFrom
     * @param string $dateTo
     * @param string|null $status
     * @return \Illuminate\Support\Collection
     */
    public static function getPaymentMethodsBreakdown(?int $brokerId, string $dateFrom, string $dateTo, ?string $status = null): \Illuminate\Support\Collection
    {
        $query = static::whereHas('sales', function ($q) use ($brokerId, $dateFrom, $dateTo, $status) {
            $q->whereIn('status', SalesStatusConstant::getAllActiveStatuses())
              ->whereDate('sales_date', '>=', $dateFrom)
              ->whereDate('sales_date', '<=', $dateTo);

            if ($brokerId) {
                $q->where('broker_id', $brokerId);
            }

            if ($status) {
                $q->where('status', $status);
            }
        });

        $payments = $query->selectRaw('payment_method, COUNT(*) as transactions, SUM(paid_amount) as amount')
            ->groupBy('payment_method')
            ->get();

        $totalAmount = $payments->sum('amount');

        return $payments->map(function ($payment) use ($totalAmount) {
            return [
                'name' => $payment->payment_method,
                'transactions' => $payment->transactions,
                'amount' => $payment->amount,
                'percentage' => $totalAmount > 0 ? round(($payment->amount / $totalAmount) * 100, 1) : 0
            ];
        });
    }

    /**
     * @param int|null $brokerId
     * @return float
     */
    public static function getTotalSalesToday(?int $brokerId): float
    {
        $query = self::whereDate('payment_date', today())
            ->where('status', SalesStatusConstant::ACTIVE);

        if ($brokerId) {
            $query->where('broker_id', $brokerId);
        }

        return $query->sum('paid_amount');
    }
}
