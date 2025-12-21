<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StatementYearlySummary extends Model
{
    protected $table = 'statement_yearly_summary';
    protected $fillable = [
        'file_id',
        'fiscal_year',
        'total_debit',
        'total_credit',
        'credit_interest',
        'source_tax',
        'yearend_balance',
        'statement_id',
    ];

    public function file()
    {
        return $this->belongsTo(BankStatementFile::class, 'file_id', 'id');
    }


}
