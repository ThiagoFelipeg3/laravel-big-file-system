<?php

namespace App\Service;

class BillingEmailService
{
    public function send(
        string $name,
        string $email,
        string $debtAmount,
        string $devtDueDate
    ) {
        return 'Send Email with Bill: ' . BillService::create(
            $name,
            $email,
            $debtAmount,
            $devtDueDate
        );
   }
}
