<?php

namespace App\enum;

class Role
{
    const TABLES_PERMISSIONS = [
        'CAN_SEE_OVERVIEW',
        'CAN_SEE_PENDING',
        'CAN_SEE_ACCEPTED',
        'CAN_SEE_ON_HOLD',
        'CAN_SEE_CANCELLED',
        'CAN_SEE_NUMBERS',
        'CAN_SEE_HISTORY'
    ];

    public static function printPermission(string $permission)
    {
        return ucfirst(
            strtolower(
                str_replace('_', ' ', $permission)
            )
        );
    }
}
