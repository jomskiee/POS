<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SalesPayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'sales_id',
        'brooker_id',
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
        return $this->belongsTo(Broker::class, 'brooker_id');
    }
}
