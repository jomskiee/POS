<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FishBox extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'qr_code',
        'fish_type_id',
        'status',
        'current_broker_id',
    ];

    protected $casts = [
        'qr_code' => 'string',
    ];

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
}