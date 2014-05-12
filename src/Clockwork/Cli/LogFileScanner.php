<?php
namespace Clockwork\Cli;

class LogFileScanner
{
    public function getNewFiles(array $dirs, $since)
    {
        $files = [];
        foreach ($dirs as $dir) {
            $dir .= '/app/storage/clockwork';
            if (is_dir($dir)) foreach (new \DirectoryIterator($dir) as $fileInfo) {
                if ($fileInfo->isFile() && $fileInfo->getExtension() == 'json') {
                    $timestamp = (float) $fileInfo->getFilename();
                    if ($timestamp > $since) {
                        $files[] = ['file' => $fileInfo->getPathname(), 'time' => $timestamp];
                    }
                }
            }
        }
        usort($files, function ($a, $b) {
            return $a['time'] - $b['time'];
        });

        return $files;
    }
}
