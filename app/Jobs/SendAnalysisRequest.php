<?php

namespace App\Jobs;

use App\Models\BankStatementAnalysis;
use App\Services\NodeAuthService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SendAnalysisRequest implements ShouldQueue
{
    use Queueable;
    protected $analysisId;

    /**
     * Create a new job instance.
     */
    public function __construct(BankStatementAnalysis $analysis)
    {
        $this->analysisId = $analysis->id;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {

            // Example: Send another request to Node server using token
            $url = config('app.api_base_url') . '/place_request';
            $analysis = BankStatementAnalysis::with(['files.bank'])->find($this->analysisId);


            $multipart = [
                ['name' => 'taxpayer_name', 'contents' => $analysis->taxpayer_name],
                ['name' => 'tin', 'contents' => $analysis->tin_no],
                ['name' => 'officer_id', 'contents' => config('app.api_user')],
            ];

            $statements = [];

            foreach ($analysis->files as $file) {

                $filePath = storage_path(   'app/public/'.$file->file_path);
                $fileName = basename($filePath);
                $bankName = $file->bank->short_name;
                $statements[] = ['bank_name' => $bankName,'path' => $fileName];
            }
            $multipart[] = ['name' => 'bank_statements', 'contents' => json_encode($statements)];

            $response = Http::asMultipart()->post($url, $multipart);

            $status = $response->status();
            $body   = $response->body();

            if (!$response->successful()) {
                // Save error response
                $this->saveResponse("HTTP $status: " . $body, false);
                Log::error("API Error: HTTP $status — $body");
                return;
            }


            $data = $response->json();
            $this->saveResponse($data, true);
            Log::info('request');
            Log::info(json_encode($multipart));
            Log::info($url);
            Log::info(json_encode($response));

            // ✅ Save request_id to each related bank file
            if (isset($data['request_id'])) {
                $requestId = $data['request_id'];
                $analysis->request_id = $requestId;
                $analysis->status = 'processing';
                $analysis->save();
                Log::info("Request ID {$requestId} saved to bank_statement_files table.");
            } else {
                Log::warning('No request_id found in Node response.');
            }
        }catch (\Exception $exception){
            $this->saveResponse($exception->getMessage(), false);

            Log::error($exception->getMessage());
        }


    }
    private function saveResponse($response, $success)
    {
        $analysis = BankStatementAnalysis::find($this->analysisId);

        $analysis->api_response = is_array($response) ? json_encode($response) : $response;
        $analysis->api_success  = $success ? 1 : 0;

        if (!$success) {
            $analysis->status = 'failed';
        }

        $analysis->save();
    }
}
