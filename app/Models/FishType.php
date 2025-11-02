<?php

namespace App\Models;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FishType extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'broker_id',
    ];

    /**
     * Get the broker that owns this fish type.
     */
    public function broker()
    {
        return $this->belongsTo(Broker::class, 'broker_id');
    }

    /**
     * Get the fish boxes for this fish type.
     */
    public function fishBoxes()
    {
        return $this->hasMany(FishBox::class);
    }

    /**
     * Check if this fish type is used by checking if fish boxes exist with the same broker_id
     *
     * @return bool
     */
    public function isUsed(): bool
    {
        return $this->fishBoxes()
            ->where('broker_id', $this->broker_id)
            ->exists();
    }

    // =============== DATABASE OPERATIONS =============== //

    /**
     * Get fish types by broker id
     *
     * @param int|null $brokerId
     *
     * @return Collection
     */
    public static function getFishTypeByBrokerId(?int $brokerId = null): Collection
    {
        $query = static::query();

        if ($brokerId) {
            $query->where('broker_id', $brokerId);
        }

        return $query->get();
    }

    /**
     * Get paginated fish types with search functionality
     *
     * @param string|null $search
     * @param int|null $brokerId
     * @param int $perPage
     *
     * @return LengthAwarePaginator
     */
    public static function getPaginatedWithSearch(?string $search = null, ?int $brokerId = null, int $perPage = 12): LengthAwarePaginator
    {
        $query = static::query();

        // Filter by broker if provided
        if ($brokerId) {
            $query->where('broker_id', $brokerId);
        }

        // Apply search filter
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%');
            });
        }

        // Order by creation date and paginate
        return $query->orderBy('created_at', 'desc')->paginate($perPage);
    }

}
