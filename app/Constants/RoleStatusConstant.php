<?php

namespace App\Constants;

class RoleStatusConstant
{
    public const ADMIN = 'admin';
    public const BROKER = 'broker';

    public static function getAllRoles(): array
    {
        return [
            self::ADMIN,
            self::BROKER,
        ];
    }

    public static function isValidRole(string $role): bool
    {
        return in_array($role, self::getAllRoles());
    }
}
