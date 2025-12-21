<?php

namespace App\Jobs;

use App\Models\BankStatementFile;
use App\Models\Transaction;
use App\Services\NodeAuthService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GetDetailsTransection implements ShouldQueue
{
    use Queueable;

    protected $statement;

    /**
     * Create a new job instance.
     */
    public function __construct(BankStatementFile $statement)
    {
        $this->statement = $statement;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            $url = rtrim(Config::get('app.api_base_url'), '/') . '/getdetails';
            $tokenService = new NodeAuthService();
            $token = $tokenService->getToken();

            // Correct multipart format
            $response = Http::asMultipart()->post($url, [
                'statement_id' => $this->statement->statement_id,
                'token'        => $token,
                'fiscal_year'  => 'all',
                'type'         => 'all',
            ]);

            if (!$response->successful()) {
                Log::error("TransectionDetails: API call failed", [
                    'statement_id' => $this->statement->statement_id,
                    'status' => $response->status(),
                    'body' => $response->body(),
                ]);
                return;
            }

            $responseData = $response->json();

            if (empty($responseData)) {
                Log::warning("TransectionDetails: Empty response", [
                    'statement_id' => $this->statement->statement_id,
                ]);
                return;
            }

            foreach ($responseData as $item) {

                Transaction::create([
                    'file_id'          => $this->statement->id,
                    'transaction_code' => $item['transaction_code'] ?? '',
                    'details'          => $item['details'] ?? '',
                    'ref'              => $item['ref'] ?? '',
                    'date'              => $item['date'] ?? null,
                    'cheque'           => $item['cheque'] ?? '',
                    'debit'            => $this->toDecimal($item['debit'] ?? null),
                    'credit'           => $this->toDecimal($item['credit'] ?? null),
                    'balance'          => $this->toDecimal($item['balance'] ?? null),
                ]);
            }

            Log::info("TransectionDetails: Saved successfully", [
                'statement_id' => $this->statement->statement_id,
                'total_saved'  => count($responseData),
            ]);

        } catch (\Throwable $exception) {
            Log::error("GetDetailsTransection Job Failed", [
                'error'        => $exception->getMessage(),
                'file'         => $exception->getFile(),
                'line'         => $exception->getLine(),
                'statement_id' => $this->statement->statement_id,
            ]);
        }
    }

    private function toDecimal($value)
    {
        return ($value === "" || $value === null) ? null : $value;
    }
}
