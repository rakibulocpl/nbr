<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BankStatementFile extends Model
{
    protected $table = 'bank_statement_files';
    protected $fillable = [
        'bank_statement_analysis_id',
        'bank_id',
        'file_path',
        'acc_no',
        'acc_type',
        'opening_balance',
        'closing_balance',
        'statement_id',
        'original_file_name',
        'created_by',
        'updated_by'
    ];

    public function bank()
    {
        return $this->belongsTo(Bank::class, 'bank_id');
    }
    public function statement()
    {
        return $this->belongsTo(Statement::class, 'statement_id');
    }
    public function analysis()
    {
        return $this->belongsTo(BankStatementAnalysis::class, 'bank_statement_analysis_id', 'id');
    }
    public function yearlySummaries()
    {
        return $this->hasMany(Summary::class, 'statement_id','statement_id');
    }
}
