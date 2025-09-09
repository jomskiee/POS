<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Sales extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'sales_date',
        'brooker_id',
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
    public function broker()
    {
        return $this->belongsTo(Broker::class, 'brooker_id');
    }

    public function salesDetails()
    {
        return $this->hasMany(SalesDetails::class, 'sales_id');
    }

    public function salesPayments()
    {
        return $this->hasMany(SalesPayment::class, 'sales_id');
    }

    // Helper methods
    public function getRemainingAmountAttribute()
    {
        return $this->total_amount - $this->paid_amount;
    }

    public function updatePaymentStatus()
    {
        if ($this->paid_amount <= 0) {
            $this->status = 'Active';
        } elseif ($this->paid_amount >= $this->total_amount) {
            $this->status = 'Paid';
        } else {
            $this->status = 'Partially_Paid';
        }
        $this->save();
    }

    /**
     * Update paid amount based on all active payments
     */
    public function updatePaidAmount()
    {
        $this->paid_amount = $this->salesPayments()
            ->where('status', 'Active')
            ->sum('paid_amount');
        $this->save();
    }

    /**
     * Get paginated sales with filters
     */
    public static function getPaginatedWithFilters($search = null, $status = null, $brookerId = null)
    {
        $query = self::with(['broker', 'salesDetails', 'salesPayments']);

        if ($brookerId) {
            $query->where('brooker_id', $brookerId);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('buyer_name', 'like', "%{$search}%")
                  ->orWhere('buyer_contact', 'like', "%{$search}%")
                  ->orWhere('uuid', 'like', "%{$search}%");
            });
        }

        if ($status) {
            $query->where('status', $status);
        }

        return $query->orderBy('created_at', 'desc')->paginate(15);
    }
}
