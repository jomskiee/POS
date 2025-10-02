<?php

namespace App\Constants;

class FishBoxStatusConstant
{
    public const IN_STOCK = 'In Stock';
    public const SOLD = 'Sold';
    public const RETURNED = 'Returned';
    public const MISSING = 'Missing';

    /**
     * @return array
     */
    public static function getAllStatuses(): array
    {
        return [
            self::IN_STOCK,
            self::SOLD,
            self::RETURNED,
            self::MISSING,
        ];
    }

    public static function getStatusOnlyForAdmin(): array
    {
        return [
            self::RETURNED,
            self::MISSING,
        ];
    }
}
