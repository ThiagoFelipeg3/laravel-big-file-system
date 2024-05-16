<?php

namespace App\Service;

class ProcessFilesService {
    public function exec(string $filePath, Callable $callback, int $chunkSize = 100000)
    {
        try {
            $handle = fopen($filePath, "r");
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
            trigger_error("file_get_contents_chunked::" . $e->getMessage(), E_USER_NOTICE);

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
