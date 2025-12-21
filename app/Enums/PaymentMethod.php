<?php
namespace App\Enums;

enum PaymentMethod: string
{
    case CASH = 'cash';
    case BANK_TRANSFER = 'bank_transfer';
    case CHEQUE = 'cheque';
    case MOBILE_BANKING = 'mobile_banking';
    case OTHER = 'other';

    public function label(): string
    {
        return match($this) {
            self::CASH => 'Cash',
            self::BANK_TRANSFER => 'Bank Transfer',
            self::CHEQUE => 'Cheque',
            self::MOBILE_BANKING => 'Mobile Banking',
            self::OTHER => 'Other',
        };
    }
}
