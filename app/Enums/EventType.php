<?php

namespace App\Enums;

enum EventType: string
{
    case FIRE = 'fire';
    case TRANSFER = 'transfer';

    public static function values(): array
    {
        return array_map(fn($case) => $case->value, self::cases());
    }
}
