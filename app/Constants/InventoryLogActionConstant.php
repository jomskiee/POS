<?php

namespace App\Constants;

class InventoryLogActionConstant
{
    public const STOCKED = 'Stocked';
    public const SOLD = 'Sold';
    public const RETURNED = 'Returned';
    public const MISSING = 'Missing';

    /**
     * @return array
     */
    public static function getAllActions(): array
    {
        return [
            self::STOCKED,
            self::SOLD,
            self::RETURNED,
            self::MISSING,
        ];
    }
}
