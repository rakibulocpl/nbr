<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class BankStatementAnalysis extends Model
{
    protected $table = 'bank_statement_analysis';
    protected $fillable = [
        'taxpayer_name',
        'tin_no',
        'trade_license',
        'bin_no',
        'contact_person',
        'contact_number',
        'project_id',
        'tender_ref_no',
        'tender_amount',
        'api_response',
        'api_success',
        'status',
        'created_by',
        'updated_by'
    ];

    public function files()
    {
        return $this->hasMany(BankStatementFile::class, 'bank_statement_analysis_id');
    }


    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (Auth::check()) {
                $model->created_by = Auth::id();
                $model->updated_by = Auth::id();
            }
        });

        static::updating(function ($model) {
            if (Auth::check()) {
                $model->updated_by = Auth::id();
            }
        });
    }
}
