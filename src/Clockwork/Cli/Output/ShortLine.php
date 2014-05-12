<?php
namespace Clockwork\Cli\Output;

class ShortLine extends Base
{
    public function output(array $log)
    {
        echo $this->color(sprintf(
            '%s %s %s %s %s' . PHP_EOL,
            date('H:m:i', $log['time']),
            $log['responseStatus'] >= 300 ? "{red}$log[responseStatus]{default}" : "{green}$log[responseStatus]{default}",
            $log['method'],
            $log['uri'],
            $log['headers']['host'][0]
        ));
    }
}
