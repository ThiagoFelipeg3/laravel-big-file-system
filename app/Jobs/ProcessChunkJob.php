<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ProcessChunkJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $list;

    public function __construct($list)
    {
        $this->list = $list;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Log::debug('Lista de Nome e Email', $this->list);
    }
}
