<?php
namespace Clockwork\Cli;

class LogFileScanner
{
    /** @var array */
    private $dirs;

    public function __construct(array $dirs)
    {
        $this->dirs = $dirs;
    }

    public function getNewFiles($since)
    {
        $files = array();
        foreach ($this->dirs as $dir) {
            $dir = $this->getClockworkDirectory($dir);
            if (is_dir($dir)) foreach (new \DirectoryIterator($dir) as $fileInfo) {
                if ($fileInfo->isFile() && $fileInfo->getExtension() == 'json') {
                    $timestamp = (float) $fileInfo->getFilename();
                    if ($timestamp > $since) {
                        $files[] = array('file' => $fileInfo->getPathname(), 'time' => $timestamp);
                    }
                }
            }
        }
        usort($files, function ($a, $b) {
            return $a['time'] - $b['time'];
        });

        return $files;
    }

    private function getClockworkDirectory($dir)
    {
        if (file_exists($dir.'/app/storage/clockwork')) {
            return $dir.'/app/storage/clockwork';
        } else {
            return $dir.'/storage/clockwork';
        }
    }
}
