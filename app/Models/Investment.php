<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Investment extends Model
{
    protected $fillable = [
        'investor_id',
        'collected_by',
        'description',
        'date',
        'transection_type',
        'payment_method',
        'transection_type',
        'amount',
    ];
}
