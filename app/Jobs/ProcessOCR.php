<?php

namespace App\Jobs;

use App\Models\FileRepo;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ProcessOCR implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $fileRepo;
    protected $filePath;

    public function __construct(FileRepo $fileRepo, string $filePath)
    {
        $this->fileRepo = $fileRepo;
        $this->filePath = $filePath;
    }

    public function handle(): void
    {
        try {
            $fileFullPath = storage_path('app/public/' . $this->filePath);

            // 🔗 Send file to OCR API
            $response = Http::timeout(300) // allow longer time for OCR
            ->attach(
                'file',
                file_get_contents($fileFullPath),
                basename($fileFullPath)
            )
                ->post('https://dev-socket.edge.gov.bd/api/ocr');

            if ($response->failed()) {
                throw new \Exception('OCR API request failed: ' . $response->body());
            }

            $data = $response->json();

            if (!isset($data['success']) || !$data['success']) {
                throw new \Exception('OCR failed: ' . ($data['error'] ?? 'Unknown error'));
            }

            $content = $data['text'] ?? '';

            // ✅ Update DB record
            $this->fileRepo->update([
                'content' => $content,
            ]);

            Log::info("✅ OCR processed successfully for FileRepo ID {$this->fileRepo->id}");
        } catch (\Exception $e) {
            Log::error("❌ OCR processing failed for FileRepo ID {$this->fileRepo->id}: " . $e->getMessage());
            $this->fileRepo->update(['processing_status' => 'failed']);
        }
    }
}
