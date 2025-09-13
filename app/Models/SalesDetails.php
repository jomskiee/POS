<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SalesDetails extends Model
{
    use HasFactory;

    protected $fillable = [
        'sales_id',
        'broker_id',
        'box_id',
        'item',
        'item_description'
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

    public function fishBox()
    {
        return $this->belongsTo(FishBox::class, 'box_id');
    }
}
