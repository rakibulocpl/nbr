<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class InvestorBalance extends Authenticatable
{

    protected $table = 'investor_balance_histories';
    protected $fillable = [
        'investor_id',
        'ref_transection_id',
        'balance',
        'effective_from',
        'effective_to',
    ];
}
