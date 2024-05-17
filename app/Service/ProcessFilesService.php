<?php

namespace App\Service;

class ProcessFilesService {
    public function exec(string $filePath, $callback, int $chunkSize = 100000)
    {
        $handle = fopen($filePath, "r");
        try {
            $lastLinePreviousChunk = '';

            while (!feof($handle)) {
                $chunk = fread($handle, $chunkSize);
                $lineArray = preg_split("/\r\n|\n|\r/", $chunk);
                $firstLine = array_shift($lineArray);

                $listBrokenLines = $this->brokenLines($firstLine, $lastLinePreviousChunk);
                $lastLinePreviousChunk = array_pop($lineArray);

                $callback([...$listBrokenLines, ...$lineArray]);
            }

            fclose($handle);

        } catch (\Exception $e) {
            fclose($handle);
        }
    }

    private function brokenLines($firstLine, $lastLinePreviousChunk): array
    {
        $firstLineExplode = explode(',', $firstLine);
        if ($firstLineExplode[0] == 'name') {
            return [];
        }

        $countColumnsfirstLine = count($firstLineExplode);
        $countColumnsLastLine = count(explode(',', $lastLinePreviousChunk));

        if ($countColumnsLastLine !== $countColumnsfirstLine) {
            return [ $lastLinePreviousChunk . $firstLine ];
        }

        return [ $lastLinePreviousChunk, $firstLine ];
    }
}
