<?php

namespace App\Jobs;

use App\Models\BankStatementAnalysis;
use App\Models\BankStatementFile;
use App\Models\StatementYearlySummary;
use App\Services\NodeAuthService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class StatusCheck implements ShouldQueue
{
    use Queueable;

    protected $analysis;

    /**
     * Create a new job instance.
     */
    public function __construct(BankStatementAnalysis $analysis)
    {
        $this->analysis = $analysis;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            $url = rtrim(Config::get('app.api_base_url'), '/') . '/getsummery';
            $tokenService = new NodeAuthService();
            $token = $tokenService->getToken();

            // 🔹 Send POST request to Node API
            $response = Http::asMultipart()->post($url, [
                [
                    'name' => 'request_id',
                    'contents' => $this->analysis->request_id,
                ],
                [
                    'name' => 'token',
                    'contents' => $token,
                ],
            ]);

            if (!$response->successful()) {
                Log::error("StatusCheck: API call failed", [
                    'analysis_id' => $this->analysis->id,
                    'status' => $response->status(),
                    'body' => $response->body(),
                ]);
                return;
            }

            $responseData = json_decode($response->body());
            if (empty($responseData)) {
                Log::warning("StatusCheck: Empty response received", [
                    'analysis_id' => $this->analysis->id,
                ]);
                return;
            }

            $position = 0;

            foreach ($responseData as $result) {
                $file = BankStatementFile::where('bank_statement_analysis_id', $this->analysis->id)
                    ->skip($position)
                    ->first();

                if (!$file) {
                    Log::warning("StatusCheck: No file found at position {$position} for analysis ID {$this->analysis->id}");
                    $position++;
                    continue;
                }



                // 🔹 Update bank statement file info
                $file->update([
                    'acc_no'          => $result->acc_no ?? null,
                    'acc_type'        => $result->acc_type ?? null,
                    'opening_balance' => $result->opening_balance ?? 0,
                    'closing_balance' => $result->closing_balance ?? 0,
                    'statement_id'    => $result->statement_id ?? null,
                ]);
                if (!empty($result->tags)) {
                    \App\Models\StatementTag::where('file_id', $file->id)->delete();
                    foreach ($result->tags as $tag => $count) {
                        \App\Models\StatementTag::create([
                            'file_id' => $file->id,
                            'tag'     => $tag,
                            'count'   => $count,
                        ]);
                    }
                }
                GetDetailsTransection::dispatch($file);

                // 🔹 Delete old yearly summary entries (to avoid duplicates)
                StatementYearlySummary::where('file_id', $file->id)->delete();

                // 🔹 Save new summary data
                if (!empty($result->data)) {
                    foreach ($result->data as $value) {
                        StatementYearlySummary::create([
                            'file_id'         => $file->id,
                            'statement_id'    => $result->statement_id ?? null,
                            'fiscal_year'     => $value->fiscal_year ?? null,
                            'total_debit'     => $value->total_debit ?? 0,
                            'total_credit'    => $value->total_credit ?? 0,
                            'credit_interest' => $value->credit_interest ?? 0,
                            'source_tax'      => $value->source_tax ?? 0,
                            'yearend_balance' => $value->yearend_balance ?? 0,
                        ]);
                    }
                }

                $position++;
            }

            // 🔹 Update analysis status
            $this->analysis->update(['status' => 'done']);

            Log::info("StatusCheck completed successfully", [
                'analysis_id' => $this->analysis->id,
            ]);

        } catch (\Throwable $exception) {
            Log::error("StatusCheck Job Failed", [
                'error' => $exception->getMessage(),
                'file'  => $exception->getFile(),
                'line'  => $exception->getLine(),
                'analysis_id' => $this->analysis->id,
            ]);
        }
    }
}
