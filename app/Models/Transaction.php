<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;
use App\Enums\TransactionType;

class Transaction extends Model
{
    use Searchable;
    protected $guarded = ['id'];


}
