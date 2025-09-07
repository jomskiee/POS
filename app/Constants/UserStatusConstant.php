<?php

namespace App\Constants;

class UserStatusConstant
{
    public const ACTIVE = 'active';
    public const DEACTIVATED = 'deactivated';

    public static function getAllStatuses(): array
    {
        return [
            self::ACTIVE,
            self::DEACTIVATED,
        ];
    }

    public static function isValidStatus(string $status): bool
    {
        return in_array($status, self::getAllStatuses());
    }
}
