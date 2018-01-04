<?php

namespace Kosv\DslTools\Helpers;

use RuntimeException;
use SplFileInfo;

class FileHelper
{
    /**
     * @param string $file
     * @param string $fromEncoding
     * @param string $toDir
     * @return \SplFileInfo
     */
    public static function convertToUtf8($file, $fromEncoding, $toDir = DSLTOOLS_TMP_DIR)
    {
        $fromHandle = fopen($file, 'r');
        stream_filter_append($fromHandle, 'convert.iconv.'. $fromEncoding . '/' . 'UTF-8');

        $tmpFile = $toDir . basename($file) . '.utf-8.tmp';
        $toHandle = fopen($tmpFile, 'w');

        if (stream_copy_to_stream($fromHandle, $toHandle) === false) {
            throw new RuntimeException("Failed copy stream: {$file} to stream: {$tmpFile}");
        }

        fclose($fromHandle);
        fclose($toHandle);

        return new SplFileInfo($tmpFile);
    }
}