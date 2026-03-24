<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class GenerateCandidatePdfJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $files;
    public $candidateId;
    public $filename;

    // ⏱ Max execution time (seconds)
    public $timeout = 300;

    //  Retry attempts
    public $tries = 3;

    public function __construct($files, $candidateId, $filename)
    {
        $this->files = $files;
        $this->candidateId = $candidateId;
        $this->filename = $filename;
    }

    public function handle()
    {
        try {

            $html = '
            <style>
                @page { size: A4; margin: 10mm; }
                body { margin: 0; padding: 0; }
                .page {
                    width: 100%;
                    height: 100%;
                    text-align: center;
                    page-break-after: always;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                }
                .page img {
                    width: 100%;
                    height: 100%;
                    object-fit: contain;
                }
            </style>';

            foreach ($this->files as $path) {

                //  Correct storage path
                $fullPath = storage_path('app/public/' . $path);

                if (!file_exists($fullPath)) {
                    Log::warning("File not found: " . $fullPath);
                    continue;
                }

                $html .= '
                <div class="page">
                    <img src="'.$fullPath.'">
                </div>';
            }

            // Generate PDF
            $pdf = \Pdf::loadHTML($html)->setPaper('a4', 'portrait');

            // Save PDF
            Storage::disk('public')->put(
                "candidate_docs/{$this->candidateId}/" . $this->filename,
                $pdf->output()
            );

            //  Cleanup temp images
            foreach ($this->files as $path) {
                Storage::disk('public')->delete($path);
            }

        } catch (\Exception $e) {

            //  Log error (important for debugging)
            Log::error('GenerateCandidatePdfJob Failed: ' . $e->getMessage(), [
                'candidate_id' => $this->candidateId,
                'filename' => $this->filename,
            ]);
        }
    }
}