<?php

namespace App\Constants;

class SalesStatusConstant
{
    public const ACTIVE = 'Active';
    public const PARTIALLY_PAID = 'Partially_Paid';
    public const PAID = 'Paid';
    public const DELETED = 'Deleted';

    /**
     * @return array
     */
    public static function getAllStatuses(): array
    {
        return [
            self::ACTIVE,
            self::PARTIALLY_PAID,
            self::PAID,
            self::DELETED,
        ];
    }

    public static function getAllActiveStatuses(): array
    {
        return [
            self::ACTIVE,
            self::PARTIALLY_PAID,
            self::PAID,
        ];
    }

    /**
     * Get status display name
     *
     * @param string $status
     * @return string
     */
    public static function getDisplayName(string $status): string
    {
        return match ($status) {
            self::ACTIVE => 'Active',
            self::PARTIALLY_PAID => 'Partially Paid',
            self::PAID => 'Paid',
            self::DELETED => 'Deleted',
            default => $status,
        };
    }

    /**
     * Get status color classes for UI
     *
     * @param string $status
     * @return string
     */
    public static function getStatusColorClasses(string $status): string
    {
        return match ($status) {
            self::PAID => 'bg-green-100 text-green-800',
            self::PARTIALLY_PAID => 'bg-yellow-100 text-yellow-800',
            self::ACTIVE => 'bg-blue-100 text-blue-800',
            self::DELETED => 'bg-red-100 text-red-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }
}
