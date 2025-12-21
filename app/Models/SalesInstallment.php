<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SalesInstallment extends Model
{
    protected $table = 'sale_installments';
    protected $fillable = [
        'sales_id',
        'type',
        'amount',
        'payment_date',
        'payment_method',
        'collected_by',
        'notes'
    ];

    public function sales(): BelongsTo
    {
        return $this->belongsTo('App\Models\LandSale', 'sales_id');
    }
}
