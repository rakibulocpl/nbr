<?php

namespace App\Console\Commands;

use App\Models\BankStatementAnalysis;
use Illuminate\Console\Command;
use App\Jobs\SendAnalysisRequest;

class SendAnalysisCommand extends Command
{
    protected $signature = 'send:analysis';
    protected $description = 'Dispatch the SendAnalysisRequest job';

    public function handle()
    {
        $analysis = BankStatementAnalysis::where('status','pending')->latest()->first();
        SendAnalysisRequest::dispatch($analysis);
        $this->info('SendAnalysisRequest job dispatched successfully.');
    }
}
