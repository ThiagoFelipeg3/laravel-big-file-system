<?php

namespace App\Jobs;

use App\Service\BillingEmailService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ProcessChunkJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(private $debtors)
    {
        $this->onQueue('process_chunk');
    }

    public function handle(BillingEmailService $billingEmail): void
    {
        try {
            foreach ($this->debtors as $debtor) {
                [ $name, $governmentId, $email, $debtAmount, $debtDueDate, $debtId ] = explode(',', $debtor);

                $billingEmail->send($name, $email, $debtAmount, $debtDueDate);
                // Log::info($response);
            }
        } catch (\Exception $error) {
            Log::error("Message: ". $error->getMessage(), [
                $error->getFile(),
                $error->getLine(),
            ]);
        }
    }
}
