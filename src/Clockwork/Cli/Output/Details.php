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
    }

    private function outputHeaders(array $log)
    {
        echo PHP_EOL;
        echo $this->color('{yellow}REQUEST HEADERS{default}');
        echo PHP_EOL;
        foreach ($log['headers'] as $name => $header) {
            echo $this->color("{cyan}" . ucwords($name) . ":{default} " . implode(';', $header) . "\n");
        }
    }

    private function outputQueries(array $log)
    {
        $keywords = array('SELECT', 'FROM', 'WHERE', 'GROUP BY', 'ORDER BY', 'INSERT', 'INTO', 'VALUES', 'UPDATE', 'SET', 'HAVING');
        echo PHP_EOL;
        echo $this->color('{yellow}DATABASE QUERIES{default}');
        echo PHP_EOL;
        foreach ($log['databaseQueries'] as $query) {
            echo sprintf('%7.3f ', $query['duration']);
            echo $this->color(preg_replace('/' . implode('|', $keywords) . '/', '{cyan}$0{default}', $query['query']));
            echo PHP_EOL;
        }
    }

    private function outputTimeline(array $log)
    {
        echo PHP_EOL;
        echo $this->color('{yellow}TIMELINE{default}');
        echo PHP_EOL;
        foreach ($log['timelineData'] as $item) {
            echo sprintf('%7.3f ', $item['duration']);
            echo $item['description'];
            echo PHP_EOL;
        }
    }

    private function outputGeneral(array $log)
    {
        echo PHP_EOL;
        echo $this->color('{yellow}GENERAL{default}');
        echo PHP_EOL;
        echo $this->color("{cyan}ID:{default} $log[id]"), PHP_EOL;
        echo $this->color("{cyan}Time:{default} $log[time]"), PHP_EOL;
        echo $this->color("{cyan}Method:{default} $log[method]"), PHP_EOL;
        echo $this->color("{cyan}URI:{default} $log[uri]"), PHP_EOL;
        echo $this->color("{cyan}Controller:{default} $log[controller]"), PHP_EOL;
        echo $this->color("{cyan}Response status:{default} $log[responseStatus]"), PHP_EOL;
    }
}
