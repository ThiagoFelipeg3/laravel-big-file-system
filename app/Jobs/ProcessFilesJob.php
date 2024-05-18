<?php

namespace App\Jobs;

use App\Service\ProcessFilesService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessFilesJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(private string $filePath)
    {
        $this->onQueue('process_files');
    }

    /**
     * Execute the job.
     */
    public function handle(ProcessFilesService $fileService): void
    {
        $fileService->exec($this->filePath, function (array $billingList) {
            ProcessChunkJob::dispatch($billingList);
        });
    }
}

