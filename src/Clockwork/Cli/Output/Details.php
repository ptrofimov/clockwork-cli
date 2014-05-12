<?php
namespace Clockwork\Cli\Output;

class Details
{
    public function output($file)
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
}
