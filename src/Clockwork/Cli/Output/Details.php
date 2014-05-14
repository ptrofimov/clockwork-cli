<?php
namespace Clockwork\Cli\Output;

class Details extends Base
{
    public function output(array $log)
    {
        $this->outputHeaders($log);
        $this->outputQueries($log);
        $this->outputTimeline($log);
        $this->outputGeneral($log);
        echo PHP_EOL;
    }

    private function outputHeaders(array $log)
    {
        echo PHP_EOL;
        echo $this->color('{yellow}REQUEST HEADERS{default}');
        echo PHP_EOL;
        foreach ($log['headers'] as $name => $header) {
            echo $this->color("{light blue}" . ucwords($name) . ":{default} " . implode(';', $header) . "\n");
        }
    }

    private function outputQueries(array $log)
    {
        $keywords = array('SELECT', 'FROM', 'WHERE', 'GROUP BY', 'ORDER BY', 'INSERT', 'INTO', 'VALUES', 'UPDATE', 'SET', 'HAVING', 'IN', 'IS', 'NULL', 'ASC', 'DESC');
        echo PHP_EOL;
        echo $this->color('{yellow}DATABASE QUERIES{default} ');
        echo sprintf("(%d, %.3f)", count($log['databaseQueries']), $log['databaseDuration'] / 1000);
        echo PHP_EOL;
        foreach ($log['databaseQueries'] as $query) {
            echo sprintf('%7.3f ', $query['duration'] / 1000);
            echo $this->color(preg_replace('/\b(' . implode('|', $keywords) . ')\b/i', '{light blue}$0{default}', $query['query']));
            echo PHP_EOL;
        }
    }

    private function outputTimeline(array $log)
    {
        $time = array();
        foreach ($log['timelineData'] as $item) {
            $time[] = $item['start'];
            $time[] = $item['end'];
        }
        $min = min($time);
        $max = max($time);
        $step = ($max - $min) / 10;

        echo PHP_EOL;
        echo $this->color('{yellow}TIMELINE{default}');
        echo PHP_EOL;
        foreach ($log['timelineData'] as $item) {
            echo sprintf('%7.3f ', $item['duration'] / 1000);
            for ($i = $min; $i < $max - $step; $i += $step) {
                echo $i + $step < $item['start'] || $i >= $item['end'] ? '.' : '#';
            }
            echo ' ', trim($item['description'], '.');
            echo PHP_EOL;
        }
    }

    private function outputGeneral(array $log)
    {
        echo PHP_EOL;
        echo $this->color('{yellow}GENERAL{default}');
        echo PHP_EOL;
        echo $this->color("{light blue}ID:{default} $log[id]"), PHP_EOL;
        echo $this->color("{light blue}Time:{default} " . date('Y-m-d H:i:s', $log['time'])), PHP_EOL;
        echo $this->color("{light blue}Duration:{default} " . sprintf('%.3f', $log['responseDuration'] / 1000)), PHP_EOL;
        echo $this->color("{light blue}Method:{default} $log[method]"), PHP_EOL;
        echo $this->color("{light blue}URI:{default} $log[uri]"), PHP_EOL;
        echo $this->color("{light blue}Controller:{default} $log[controller]"), PHP_EOL;
        echo $this->color("{light blue}Response status:{default} $log[responseStatus]"), PHP_EOL;
    }
}
