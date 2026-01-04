<?php

namespace App\Enums;

enum TransactionType: int
{
    case CASH     = 1;
    case TRANSFER   = 2;
    case CHEQUE    = 3;
    case OTHER    = 4;

    public static function fromSlug(?string $slug): ?self
    {
        return match (strtolower($slug)) {
            'cash'     => self::CASH,
            'transfer'     => self::TRANSFER,
            'cheque'   => self::CHEQUE,
            'other'    => self::OTHER,
            default    => null,
        };
    }
}
