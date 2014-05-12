<?php

$period = 0.1;
$since = microtime(true);
system("stty -echo -icanon min 0 time 0");
$dirs = array_slice($argv, 1);
if (empty($dirs)) {
    $dirs = [getcwd()];
}
$links = [];
$hotKey = 'a';
while (true) {
    $files = getClockworkLogFiles($dirs, $since);
    foreach ($files as $file) {
        $log = json_decode(file_get_contents($file['file']), true);
        echo $hotKey . ' ';
        echo date('H:m:i', $log['time']) . ' ';
        echo "$log[method] $log[uri] ({$log['headers']['host'][0]})\n";
        $links[$hotKey] = $file['file'];
        $hotKey = $hotKey == 'z' ? 'a' : chr(ord($hotKey) + 1);
    }
    usleep($period * 1000000);
    if (!empty($files)) {
        $since = array_pop($files)['time'];
    }
    foreach (str_split(fread(STDIN, 100)) as $char) if (isset($links[$char])) {
        showDetails($links[$char]);
    }
}

function getClockworkLogFiles(array $dirs, $since)
{
    $files = [];
    foreach ($dirs as $dir) {
        $dir .= '/app/storage/clockwork';
        if (is_dir($dir)) foreach (new DirectoryIterator($dir) as $fileInfo) {
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

function showDetails($file)
{
    $log = json_decode(file_get_contents($file), true);
    echo "\n";
    echo "ID: $log[id]\n";
    echo "time: $log[time]\n";
    echo "method: $log[method]\n";
    echo "uri: $log[uri]\n";
    echo "\nheaders:\n";
    foreach ($log['headers'] as $name => $header) {
        echo "$name: " . implode(';', $header) . "\n";
    }
    echo "controller: $log[controller]\n";
    echo "\ncookies:\n";
    foreach ($log['cookies'] as $name => $cookie) {
        echo "$name: $cookie\n";
    }
    echo "\nDB queries:\n";
    foreach ($log['databaseQueries'] as $query) {
        echo "$query[duration] $query[query]\n";
    }
    echo "\nTimeline:\n";
    foreach ($log['timelineData'] as $item) {
        echo "$item[duration] $item[description]\n";
    }
    echo "\n";
}
