<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseInstallment extends Model
{
    protected $fillable = [
        'purchase_id',
        'type',
        'given_by',
        'note',
        'payment_date',
        'payment_method',
        'amount',
        'notes',
    ];
}
