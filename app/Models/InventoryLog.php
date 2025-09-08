<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'fish_box_id',
        'action',
        'user_id',
    ];

    /**
     * Get the fish box that owns the inventory log.
     */
    public function fishBox()
    {
        return $this->belongsTo(FishBox::class);
    }

    /**
     * Get the user that created the inventory log.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}