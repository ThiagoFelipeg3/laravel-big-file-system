<?php

namespace Tests\Unit;

use App\Service\ProcessFilesService;
use PHPUnit\Framework\TestCase;

class ProcessFilesServiceTest extends TestCase
{
    public function testShouldReadFileInParts(): void
    {
        $tmpFileCsv = tmpFile();
        fwrite($tmpFileCsv, "name,governmentId,email,debtAmount,debtDueDate,debtId
        Elijah Santos,9558,janet95@example.com,7811,2024-01-19,ea23f2ca-663a-4266-a742-9da4c9f4fcb3
        Samuel Orr,5486,linmichael@example.com,5662,2023-02-25,acc1794e-b264-4fab-8bb7-3400d4c4734d
        Leslie Morgan,9611,russellwolfe@example.net,6177,2022-10-17,9f5a2b0c-967e-4443-a03d-9d7cdcb2216f
        Joseph Rivera,1126,urangel@example.org,7409,2023-08-16,33bec852-beee-477f-ae65-1475c74e1966
        ");

        $processFile = new ProcessFilesService();
        $chunkSize = 1;

        $closure = $this
            ->getMockBuilder(\stdclass::class)
            ->addMethods(['__invoke'])
            ->getMock();

        $closure
            ->expects($this->once())
            ->method('__invoke');

        $processFile->exec(sys_get_temp_dir(), $closure, $chunkSize);

        fclose($tmpFileCsv);
    }
}
