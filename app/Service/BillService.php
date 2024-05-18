<?php

namespace App\Service;

class BillService
{
    public static function create(
        string $name,
        string $email,
        string $debtAmount,
        string $devtDueDate
    ): string {
        return sprintf(
            "Payment slip %s email: %s with a value of %s, due in %s",
            $name,
            $email,
            $debtAmount,
            $devtDueDate
        );
   }
}
