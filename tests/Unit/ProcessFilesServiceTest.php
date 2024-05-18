<?php

namespace Tests\Unit;

use App\Service\ProcessFilesService;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use PHPUnit\Framework\TestCase;


class ProcessFilesServiceTest extends TestCase
{
    public function testShouldReadFileInParts(): void
    {
        $tmpFileCsv = UploadedFile::fake()->createWithContent(
            'index.csv',
            "name,governmentId,email,debtAmount,debtDueDate,debtId
            Elijah Santos,9558,janet95@example.com,7811,2024-01-19,ea23f2ca-663a-4266-a742-9da4c9f4fcb3\n
            Samuel Orr,5486,linmichael@example.com,5662,2023-02-25,acc1794e-b264-4fab-8bb7-3400d4c4734d\n
            Leslie Morgan,9611,russellwolfe@example.net,6177,2022-10-17,9f5a2b0c-967e-4443-a03d-9d7cdcb2216f\n
        ");

        $processFile = new ProcessFilesService();
        $chunkSize = 100;

        $closure = $this
            ->getMockBuilder(\stdclass::class)
            ->addMethods(['__invoke'])
            ->getMock();

        $closure
            ->expects($this->exactly(4))
            ->method('__invoke');

        $processFile->exec(stream_get_meta_data($tmpFileCsv->tempFile)['uri'], $closure, $chunkSize);

        fclose($tmpFileCsv->tempFile);
    }
}
